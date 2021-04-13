<?php

namespace App\Controller;

use App\Entity\Actualites;
use App\Repository\ActualitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(ActualitesRepository $actualitesRepository)
    {
           // $actualites = $actualitesRepository->findAll();
            //dd($actualites);

        $actualites = $actualitesRepository->findAllActualites(4);
        ($actualites);

        return $this->render('main/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }
}
