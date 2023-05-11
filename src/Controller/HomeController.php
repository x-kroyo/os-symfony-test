<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CarRepository $carRepository): Response
    {

        $cars = $carRepository->findAll();

        return $this->render('public/home/index.html.twig', [ 'cars' => $cars ]);
    }
}
