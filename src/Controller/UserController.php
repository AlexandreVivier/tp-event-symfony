<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]  );
    }

    #[Route('/profile/edit', name: 'app_account_edit')]
    public function edit(EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $manager->persist($user);
        $manager->flush();
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()]);
    }

}