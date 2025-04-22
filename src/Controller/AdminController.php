<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Utilisation correcte du contrôleur abstrait
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController // Héritage du contrôleur abstrait
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return new Response('<h1>Bienvenue dans le tableau de bord Admin</h1>');
    }
}