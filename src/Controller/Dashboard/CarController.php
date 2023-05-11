<?php

namespace App\Controller\Dashboard;

use App\Entity\Car;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route('/dashboard/cars', name: 'dashboard.cars.') ]
class CarController extends AbstractController
{
    #[ Route('/', name: 'index', methods: ['GET']) ]
    public function index(CarRepository $carRepository) : Response
    {
        $cars = $carRepository->findAll();

        return $this->render('dashboard/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[ Route('/add', name: 'create', methods: ['GET', 'POST']) ]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {

        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard.cars.index');
        }

        return $this->render('dashboard/car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);

    }

    #[ Route('/{id}', name: 'view', methods: ['GET']) ]
    public function view(Car $car)
    {

        return $this->render('dashboard/car/view.html.twig', [ 'car' => $car ]);

    }

    #[ Route('/delete/{id}', name: 'delete', methods: ['GET']) ]
    public function destroy(Request $request, EntityManagerInterface $entityManager, Car $car) : Response
    {
        
        $entityManager->remove($car);
        $entityManager->flush();

        $this->addFlash('success', 'Category deleted successfully.');

        return $this->redirectToRoute('dashboard.categories.index');
    }


    #[ Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST']) ]
    public function edit(Request $request, EntityManagerInterface $entityManager, Car $car) : Response
    {

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            $this->addFlash('success', 'Car updated successfully.');
            return $this->redirectToRoute('dashboard.cars.index');
        }

        return $this->render('dashboard/car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);

    }

}
