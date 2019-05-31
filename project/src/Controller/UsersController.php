<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends Controller
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }


    /**
     * @Route("/users/{page}", name="users", defaults={"page": 1})
     */
    public function index(Request $request, $page)
    {
        $paginator = $this->get("knp_paginator");
        $paginat =  $paginator->paginate(
            $users = $this->usersRepository->findAll(), $request->query->getInt('page', $page), 2
        );

        return $this->render('users/index.html.twig', [
            'users' => $paginat,
        ]);
    }


    /**
     * @Route("/user/{id}", name="viewUser")
     */
    public function viewUser(Users $user)
    {
        //TODO - Реализовать высчитование возраста исходя из даты рождения.
        //TODO - Реализовать вывод данных о компании в которой работает сотрудник
        return $this->render('/users/viewUser.html.twig', [
           'user' => $user
        ]);
    }
}
