<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //On créé une instance de la classe catégorie
        $category = new Category();

        //On créé un formulaire d'un certain type : CategoryType
        //On y injecte l'instance de la classe catégorie précédemment créée
        $form = $this->createForm(CategoryType::class, $category);

        //Cela permet de traiter les données du formulaire
        $form->handleRequest($request);

        //Si le formulaire a été soumis et si les données sont valides
        //Alors je gère l'ajout de la catégorie en base de données
        if ($form->isSubmitted() && $form->isValid()) {

            //L'entity manager persist l'objet catégorie
            //Mon entity manager, prépare la catégorie a aller en base de données
            $entityManager->persist($category);

            //L'entity manager envoie pour de bon les données en base.
            $entityManager->flush();

            //J'envoie un message flash
            $this->addFlash("success","La catégorie a bien été ajouté.");

            //Je redirige vers la route de mon choix.
            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);

        }

        //Ici, si le formulaire n'a pas été soumis, on affiche la page
        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }
}
