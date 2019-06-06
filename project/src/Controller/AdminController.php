<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Users;
use App\Form\CompaniesType;
use App\Form\UsersType;
use App\Repository\CompaniesRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $companiesRepository;
    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->companiesRepository = $companiesRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $companies = $this->companiesRepository->findBy([],[],5);
        return $this->render('admin/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/admin/addEmpl", name="addEmpl")
     */
    public function addEmployee(Request $request)
    {
        //TODO - неправильно загружается файл.
        //TODO - поправить верстку форм.
        $users = new Users();
        $form = $this->createForm(UsersType::class, $users);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            return $this->redirectToRoute('addEmpl');
        }
        return $this->render('admin/addUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/addCompany", name="addCompany")
     */
    public function addCompany(Request $request)
    {
        //TODO - неправильно загружается файл.
        //TODO - поправить верстку форм.
        $company = new Companies();
        $form =  $this->createForm(CompaniesType::class, $company);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('addCompany');
        }

        return $this->render('admin/addCompany.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/editEmpl/{id}", name="editEmpl" )
     */
    public function editEmployee($id, Request $request, Users $user)
    {
        /*
         * Обновление данных.
         * */
        $users = new Users();
        $form = $this->createForm(UsersType::class, $users);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $users->setLastName($users->getLastName());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return $this->render('admin/editEmployee.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);


    }
}
