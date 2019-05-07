<?php

namespace App\Controller;

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
        $companies = $this->companiesRepository->findAll();


        return $this->render('companies/index.html.twig', [
            'companies' => $companies,
        ]);
    }




}
