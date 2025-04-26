<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Candidature;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/candidatures')]
class AdminCandidatureController extends AbstractController
{
    // Affiche les candidatures d’une offre
    #[Route('/offre/{id}', name: 'admin_candidatures_par_offre')]
    public function listeParOffre(Offre $offre, CandidatureRepository $repo): Response
    {
        $candidatures = $repo->findBy(['offre' => $offre]);

        return $this->render('admin/candidatures/index.html.twig', [
            'offre' => $offre,
            'candidatures' => $candidatures
        ]);
    }

    // Permet de changer le statut d’une candidature (tu l’as sûrement déjà ajouté)
    #[Route('/{id}/changer-statut', name: 'admin_candidature_changer_statut', methods: ['POST'])]
    public function changerStatut(Request $request, Candidature $candidature, EntityManagerInterface $em): Response
    {
        $statut = $request->request->get('statut');
        $candidature->setStatut($statut);
        $em->flush();

        return $this->redirectToRoute('admin_candidatures_par_offre', [
            'id' => $candidature->getOffre()->getId(),
        ]);
    }
}
