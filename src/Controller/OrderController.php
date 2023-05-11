<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use App\Entity\Order;
use App\Form\OrderType;

class OrderController extends AbstractController
{

    #[ Route('/orders', name: 'orders') ]
    public function index() : Response
    {

        $orders = $this->getUser()->getOrders();
        return $this->render('public/order/index.html.twig', compact('orders'));

    }

}
