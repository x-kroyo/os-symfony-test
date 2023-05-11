<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route('/dashboard/categories', name : 'dashboard.categories.') ]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('dashboard/category/index.html.twig', [ 'categories' => $categories]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Category();
        $form = $this->createForm(CategoryType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard.categories.index');
        }

        return $this->render('dashboard/category/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Category $category)
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Category updated successfully.');
            return $this->redirectToRoute('dashboard.categories.index');
        }

        return $this->render('dashboard/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function destroy(EntityManagerInterface $entityManager, Category $category): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'Category deleted successfully.');

        return $this->redirectToRoute('dashboard.categories.index');
    }
}
