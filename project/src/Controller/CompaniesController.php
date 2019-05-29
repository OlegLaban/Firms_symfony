<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\User;
use App\Form\CompaniesType;
use App\Repository\CompaniesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompaniesController extends AbstractController
{
    private $companiesRepository;

    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->companiesRepository = $companiesRepository;
    }

    /**
     * @Route("/", name="index_page")
     */

    public function index()
    {
        $companies = $this->companiesRepository->findBy([],[],4);
        $company = $this->getDoctrine()->getRepository(Companies::class)->find(5);
        $user= $this->getDoctrine()->getRepository(User::class)->find(2);
        dump($company->getEmployee());
        //$company->getEmployee()->add($user);
//        dump($company);
        $this->getDoctrine()->getManager()->persist($company);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/companies", name="viewCompanies_page")
     */
    public function viewCompanies()
    {
        $companies = $this->companiesRepository->findBy([],[],4);

        return $this->render('companies/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/company/{id}", name="viewCompany")
     */
    public function viewCompany(Companies $company)
    {
        return $this->render('companies/viewCompany.html.twig', [
            'company' => $company
        ]);

    }

    /**
     * @Route("/addCompany", name="addCompany")
     */
    public function addCompany(Request $request)
    {
        $company = new Companies();
        $form = $this->createForm(CompaniesType::class, $company);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $company->setFirmName($company->getFirmName());
            $company->setAddress($company->getAddress());
            $company->setDescription($company->getDescription());
            $company->setIdFirstEmployee($company->getIdFirstEmployee());
            $company->setOgrn($company->getOgrn());
            $company->setOktmo($company->getOktmo());
            $company->setLogo($company->getLogo());
            $company->setPhone($company->getPhone());

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('addCompany');
        }

        return $this->render('companies/addCompany.html.twig', [
            'form' => $form->createView()
        ]);

    }



}
