<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\User;
use App\Form\CompaniesType;
use App\Repository\CompaniesRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompaniesController extends Controller
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
        $user = $this->getDoctrine()->getRepository(User::class)->find(2);
        $this->getDoctrine()->getManager()->persist($company);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/companies/{page}", name="viewCompanies_page", defaults={"page": 1})
     */
    public function viewCompanies(Request $request, $page)
    {
        if(isset($_GET['filterFirm'])){
            $data = $_GET;
        }else{
            $data = [];
        }
        //Берем репозиторий.
        $repository = $this->getDoctrine()->getRepository(Companies::class);

        //Берем объект пагинатора для дальнейшей работы.
        $paginator = $this->get("knp_paginator");
        //Кладем в переменную результат работы паггинатора. в виде обекта с данными и методами.
        if(isset($data['filterFirm']) && !isset($data['resetFilterFirm'])){
            $paginat =  $paginator->paginate(
                $repository->getCompaniesWithFilter($data), $request->query->getInt('page', $page), 4
            );
        }else{
            if(isset($_GET['resetFilterFirm'])){
                unset($_GET['filterFirm']);
                unset($_GET['resetFilterFirm']);
                $data['filterFirm'] = [];
            }
            $paginat =  $paginator->paginate(
                $repository->findAll(), $request->query->getInt('page', $page), 4
            );
        }
        dump($paginat);

        //$comp = $repository->getCompaniesWithFilter($_GET);
        //dump($comp);

        //рендерим в шаблон наш объект для отображение компаний(уже с учетом паггинации) и саму пагинацию
        // внизу страницы.
        dump($data);
        return $this->render("companies/index.html.twig", [
            "paginat"=> $paginat,
            "data" => $data['filterFirm']
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
