<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureFilterType;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/candidatures')]
#[IsGranted('ROLE_ADMIN')]
class AdminCandidatureController extends AbstractController
{
    #[Route('/', name: 'admin_candidatures_index', methods: ['GET'])]
    public function index(
        Request $request,
        CandidatureRepository $candidatureRepo,
        PaginatorInterface $paginator
    ): Response {
        // Création du formulaire de filtres
        $filterForm = $this->createForm(CandidatureFilterType::class);
        $filterForm->handleRequest($request);

        // Requête avec filtres
        $query = $candidatureRepo->createQueryBuilderWithFilters($filterForm->getData());

        // Pagination
        $candidatures = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/candidature/index.html.twig', [
            'candidatures' => $candidatures,
            'filter_form' => $filterForm->createView(),
        ]);
    }

    #[Route('/{id}/status', name: 'update_status', methods: ['POST'])]
    public function updateStatus(
        Request $request,
        Candidature $candidature,
        EntityManagerInterface $em
    ): Response {
        $newStatus = $request->request->get('status');
        
        if ($candidature->isValidStatus($newStatus)) {
            $candidature->setStatus($newStatus);
            $em->flush();
            $this->addFlash('success', 'Statut mis à jour');
        }

        return $this->redirectToRoute('admin_candidatures_index');
    }

    #[Route('/{id}/view', name: 'view', methods: ['GET'])]
    public function view(Candidature $candidature): Response
    {
        return $this->render('admin/candidature/view.html.twig', [
            'candidature' => $candidature,
        ]);
    }
}