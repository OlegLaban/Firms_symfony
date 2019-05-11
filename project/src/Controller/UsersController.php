<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }


    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        $users = $this->usersRepository->findAll();
        return $this->render('users/index.html.twig', [
            'users' => $users,
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
