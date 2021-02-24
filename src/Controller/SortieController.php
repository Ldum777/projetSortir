<?php


namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route(name="sortie_", path="sortie/")
 */
class SortieController extends AbstractController
{


    /**
     * @Route(name="create", path="creer", methods={"GET", "POST"})
     */
    public function create(EntityManagerInterface $entityManager, Request $request){
        $sortie = new sortie();

        $formSortie = $this->createForm(SortieFormType::class, $sortie);
        $formSortie->handleRequest($request);

        $utilisateurEnCours = new User();
        $utilisateurEnCours= $this->getUser();
        $utilisateurEnCours=$entityManager->getRepository(User::class)->find($this->getUser()->getId());
//        dump($utilisateurEnCours);exit();
        if ($formSortie -> isSubmitted()) {
// Partie en travaux
            $sortie->setOrganisateur($utilisateurEnCours);
            $sortie->setSiteOrganisateur(
                $this->getDoctrine()->getRepository(Site::class)->find(1)
            );
            $sortie->setEtat(
                $this->getDoctrine()->getRepository(Etat::class)->find(1)
            );
//            dump($sortie->getOrganisateur());exit();
            //FIN de travaux
            $entityManager->persist($formSortie->getData());
            $entityManager->flush();
            $this->addFlash("succes", "Sortie crée !");
            return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);
        }

        return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);

        }


}