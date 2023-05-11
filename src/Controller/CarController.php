<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Entity\Order;
use App\Form\OrderType;


#[ Route('cars', name: 'cars.') ]
class CarController extends AbstractController
{

    #[Route('/{id}', name: 'view')]
    public function view(Request $request, EntityManagerInterface $entityManager, Car $car): Response
    {
        // Get the current client
        $client = $this->getUser();

        // Create a new order
        $order = new Order;
        $order->setCar($car);
        $order->setClient($client);

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $order->getQuantity() <= $car->getQuantity()) {

            // Persist the order to the database
            $entityManager->persist($order);
            $entityManager->flush();

            // Reduce the car quantity
            $car->setQuantity($car->getQuantity() - $order->getQuantity());
            $entityManager->flush();


            $this->addFlash('success', 'Order placed successfully!');
            return $this->redirectToRoute('orders');

        }

        return $this->render('public/car/view.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

}
