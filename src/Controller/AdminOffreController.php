<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/offres')]
class AdminOffreController extends AbstractController
{
    #[Route('/', name: 'admin_offres')]
    public function index(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('admin/offres/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/new', name: 'admin_offres_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('admin_offres');
        }

        return $this->render('admin/offres/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_offres_edit')]
    public function edit(Offre $offre, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_offres');
        }

        return $this->render('admin/offres/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
