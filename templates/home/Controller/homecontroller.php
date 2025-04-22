<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    private array $jobOffers = [
        ['title' => 'Développeur Symfony', 'type' => 'CDI', 'location' => 'Paris'],
        ['title' => 'Designer UX/UI', 'type' => 'CDD', 'location' => 'Lyon'],
        ['title' => 'Chef de Projet', 'type' => 'CDI', 'location' => 'Télétravail']
    ];

    private array $testimonials = [
        ['author' => 'Marie D.', 'content' => 'Excellent environnement de travail'],
        ['author' => 'Jean P.', 'content' => 'Équipe très supportive'],
        ['author' => 'Sophie L.', 'content' => 'Projets passionnants']
    ];

    #[Route('/', name: 'home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        // Formulaire de contact
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Envoi d'email
            $email = (new Email())
                ->from($data['email'])
                ->to('contact@entreprise.com')
                ->subject('Nouveau message de contact')
                ->text($data['message']);
            
            $mailer->send($email);
            
            $this->addFlash('success', 'Votre message a été envoyé !');
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'company_name' => 'Entreprise RH',
            'job_offers' => $this->jobOffers,
            'testimonials' => $this->testimonials,
            'contact_form' => $form->createView(),
            'current_page' => 'home'
        ]);
    }
}