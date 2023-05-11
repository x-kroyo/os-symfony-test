<?php

namespace App\Controller\Dashboard;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;

#[ Route('/dashboard/orders', name : 'dashboard.orders.') ]
class OrderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('dashboard/order/index.html.twig', compact('orders'));
    }

    public function destroy(Request $request, EntityManagerInterface $entityManager, Order $order) : Response
    {

        $entityManager->remove($order);
        $entityManager->flush();

        $this->addFlash('success', 'Order cancelled successfully.');

        return $this->redirectToRoute('dashboard.orders.index');

    }
}
