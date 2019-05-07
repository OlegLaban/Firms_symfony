<?php

namespace App\Controller;

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
}
