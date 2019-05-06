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
