<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'offres' => $offres,
        ]);
    }
}