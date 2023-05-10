<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route('/dashboard/cars', name: 'dashboard.cars.') ]
class CarController extends AbstractController
{
    #[ Route('/', name: 'index', methods: ['GET']) ]
    public function index()
    {

    }

    #[ Route('/add', name: 'create', methods: ['GET', 'POST']) ]
    public function create()
    {

    }

    #[ Route('/{id}', name: 'view', methods: ['GET']) ]
    public function view()
    {

    }

    #[ Route('/delete/{id}', name: 'delete', methods: ['GET']) ]
    public function destroy()
    {

    }

    #[ Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST']) ]
    public function edit()
    {

    }

}
