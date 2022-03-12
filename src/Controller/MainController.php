<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Form\ComicForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function principalRoute()
    {
        return $this->render
        (
            'base.html.twig',
        [ 'name' => 'SANDRA']

        );
    }

    // #[Route('/insert')]
    // public function insertNew(EntityManagerInterface $doctrine)
    // {
    //     $comic = new Comic();
    //     $comic->setTitle('From Hell');
    //     $comic->setDescription('Jack ha vuelto. Y, esta vez, la sangre es roja.
    //     Cinco asesinatos sin resolver. Dos grandes maestros de la historia del cómic. Una conspiración intrincada, una metrópolis al borde del siglo XX y un destripador sangriento que sumerge a Londres en la era del horror contemporáneo.');
    //     $comic->setAuthor('Alan Moore, Eddie Campbell');

    //     //save into DB
    //     $doctrine->persist($comic);
    //     $doctrine->flush();

    //     return new Response('Saved comic');
    // }

    #[Route ('/comics', name:'comic-list')]
    public function comicList(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Comics::class);
        $comics = $repo->findAll();

        return $this->render('comics/comicList.html.twig', ["comics"=>$comics]);


    }

    #[Route ('/comics/add', name:'new-comic')]
    public function addComic(Request $request, EntityManagerInterface $doctrine)
    {
        $form = $this->createForm(ComicForm::class);
        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comic = $form->getData();

            $doctrine->persist($comic);

            $doctrine->flush();

            $this->addFlash('success', 'Comic added correctly');
            return $this->redirectToRoute('/comics', ['id'=> $comic->getId()]);
        }

        return $this->renderForm('comics/addComic.html.twig', ['comicForm' => $form]);

    }

}