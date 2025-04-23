<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Important !
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController // Le contrôleur doit hériter d'AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        // Exemple de données simulées (vous pouvez les récupérer depuis la base de données)
        $offres = [
            ['id' => 1, 'titre' => 'Développeur Web', 'statut' => 'Publié', 'date' => '2025-04-20'],
            ['id' => 2, 'titre' => 'Chef de Projet IT', 'statut' => 'En attente', 'date' => '2025-04-15'],
            ['id' => 3, 'titre' => 'Designer UX/UI', 'statut' => 'Archivé', 'date' => '2025-04-10'],
        ];
    
        // Retourne une vue Twig avec les données
        return $this->render('admin/dashboard.html.twig', [
            'offres' => $offres,
        ]);
    }
}