namespace App\Controller\Admin;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'admin_candidature_index')]
    public function index(CandidatureRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_RH');
        return $this->render('admin/candidature/index.html.twig', [
            'candidatures' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_candidature_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_RH');

        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload CV + lettre à faire ici si besoin
            $em->persist($candidature);
            $em->flush();

            return $this->redirectToRoute('admin_candidature_index');
        }

        return $this->render('admin/candidature/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
