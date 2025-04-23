<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    #[Route('/offres', name: 'app_offre_index')]
    public function index(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }
}
