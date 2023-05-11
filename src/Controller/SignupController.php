<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SignupController extends AbstractController
{
    
    #[Route('/sign-up', name: 'signup')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface  $passwordHasher): Response
    {
        $client = new Client;
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($client, $form->get('password')->getData());
            $client->setPassword($hashedPassword);
            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Your account has been created successfully.');

            return $this->redirectToRoute('login');
        }

        return $this->render('public/signup/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
