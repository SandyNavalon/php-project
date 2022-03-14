<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Entity\ConditionComic;
use App\Entity\Status;
use App\Form\ComicForm;
use App\Manager\ComicManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name:'home')]
    public function principalRoute()
    {
        return $this->render
        (
            'base.html.twig',

        );
    }

    #[Route ('/comics', name:'comic-list')]
    public function comicList(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Comics::class);
        $comics = $repo->findAll();

        return $this->render('comics/comicList.html.twig', ["comics"=>$comics]);

    }

    #[Route('/insert')]
    public function insertNew(EntityManagerInterface $doctrine)
    {
        $status = new ConditionComic();
        $status ->setConditionName('New');

        $status2 = new ConditionComic();
        $status2 ->setConditionName('Almost new, little damage');

        $status3 = new ConditionComic();
        $status3 ->setConditionName('Used but readable');


        $doctrine->persist($status);
        $doctrine->persist($status2);
        $doctrine->persist($status3);


        // $comic = new Comics();
        // $comic->setTitle('From Hell');
        // $comic->setDescription('Jack ha vuelto. Y, esta vez, la sangre es roja.
        // Cinco asesinatos sin resolver. Dos grandes maestros de la historia del cómic. Una conspiración intrincada, una metrópolis al borde del siglo XX y un destripador sangriento que sumerge a Londres en la era del horror contemporáneo.');
        // $comic->setAuthor('Alan Moore, Eddie Campbell');
        // $comic->addConditionComic($status2);

        //save into DB
        // $doctrine->persist($comic);
        $doctrine->flush();

        return new Response('Saved comic');
    }

    #[Route ('/comics/add', name:'new-comic')]
    public function addComic(Request $request, EntityManagerInterface $doctrine, ComicManager $manager)
    {

        $form = $this->createForm(ComicForm::class);
        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comic = $form->getData();

            $comicImage = $form->get('image')->getData();
            if($comicImage) {
                $comicImageName = $manager->uploadImage($comicImage, $this-> getParameter('kernel.project_dir').'/public/images');
                $comic->setImage("/images/$comicImageName");
            }

            $doctrine->persist($comic);
            $doctrine->flush();

            $this->addFlash('success', 'Comic added correctly');
            return $this->redirectToRoute('comic-list', ['id'=> $comic->getId()]);
        }
        return $this->renderForm('comics/addComic.html.twig', ['comicForm' => $form]);

    }

    #[Route('comics/{id}', name:'comicDetails')]
    public function comicDetails($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Comics::class);
        $comics = $repo->find($id);

        return $this->render('comics/comicDetails.html.twig', ['comic'=>$comics]);
    }

    #[Route('/comics/delete/{id}', name:'deleteComic')]
    public function deleteComic($id, EntityManagerInterface $doctrine)
    {
        $user = $this->getUser();

        $repo = $doctrine->getRepository(Comics::class);
        $comic = $repo->find($id);

        $doctrine->remove($comic);
        $doctrine->flush();

        return $this->redirectToRoute("comic-list");
    }




}
