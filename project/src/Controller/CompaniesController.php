<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Repository\CompaniesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $companies = $this->companiesRepository->findBy([],[],5);

        return $this->render('index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/companies", name="viewCompanies_page")
     */
    public function viewCompanies()
    {
        $companies = $this->companiesRepository->findBy([],[],5);

        dump($companies);
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



}
