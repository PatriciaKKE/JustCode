<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCandidatureController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/admin/candidatures/{id}', name: 'admin_candidatures')]
    public function candidatures(int $id, OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée');
        }

        return $this->render('admin/candidatures/list.html.twig', [
            'offre' => $offre,
            'candidatures' => $offre->getCandidatures(),
        ]);
    }

    #[Route('/admin/offre/{id}/publier', name: 'admin_offre_publier')]
    public function publier(int $id, OffreRepository $offreRepository, EntityManagerInterface $em): Response
    {
        $offre = $offreRepository->find($id);
        if (!$offre) {
            throw $this->createNotFoundException();
        }

        $offre->setStatut('Publié');
        $offre->setDatePublication(new \DateTime());
        $em->flush();

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/offre/{id}/cloturer', name: 'admin_offre_cloturer')]
    public function cloturer(int $id, OffreRepository $offreRepository, EntityManagerInterface $em): Response
    {
        $offre = $offreRepository->find($id);
        if (!$offre) {
            throw $this->createNotFoundException();
        }

        $offre->setStatut('Clôturé');
        $offre->setDateFinPublication(new \DateTime());
        $em->flush();

        return $this->redirectToRoute('admin_dashboard');
    }
}