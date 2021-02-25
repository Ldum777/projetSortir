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
use App\Form\SearchSiteType;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route(name="sortie_", path="sortie/")
 */
class SortieController extends AbstractController
{
    /**
     * @Route(name="liste", path="liste", methods={"GET", "POST"})
     */
    public function sortie_liste(Request $request, EntityManagerInterface $manager)
    {
        //ENLEVER LES CROCHETS
        $sorties= $manager->getRepository('App:Sortie')->findAll();
        //CHANGER la fonction findAll, elle retour un tableau de tableaux

        //Chargement des catégories
        $formSearchSite = $this->createForm(SearchSiteType::class);
        $formSearchSite->handleRequest($request);

        if($formSearchSite->isSubmitted() && $formSearchSite->isValid()){
            //Préparation du filtre pour ne pas afficher le bouton Inscription pour les sorties auxquelles on est déjà isncrit
            $utilisateurEnCours = $this->getUser();
            $sortieUser=$manager->getRepository(Sortie::class)->
            findBySortieUser($manager, $sorties, $utilisateurEnCours->getId());

            $site = $formSearchSite->get('site')->getData();
            $sortiesSite=$manager->getRepository(Sortie::class)->findBySite($manager, $site);
            return $this->render('sortie/liste.html.twig', ['sorties'=>$sortiesSite, 'mesSorties' => $sortieUser, 'formSearchSite'=>$formSearchSite->createView()]);
        }

        //Préparation du filtre pour ne pas afficher le bouton Inscription pour les sorties auxquelles on est déjà isncrit
        $utilisateurEnCours = $this->getUser();
        $sortieUser=$manager->getRepository(Sortie::class)->
        findBySortieUser($manager, $sorties, $utilisateurEnCours->getId());

//        $lieu = $manager->getRepository('App:Lieu')->find(2);

        return $this->render('sortie/liste.html.twig',
            ['sorties'=>$sorties,
                'mesSorties' => $sortieUser,
                'formSearchSite'=>$formSearchSite->createView()]);
    }

    /**
     * @Route(name="create", path="creer", methods={"GET", "POST"})
     */
    public function create(EntityManagerInterface $entityManager, Request $request){
        $sortie = new sortie();

        $formSortie = $this->createForm(SortieFormType::class, $sortie);
        $formSortie->handleRequest($request);


        /**
         * @var User
         */
        $utilisateurEnCours= $this->getUser();
       // $utilisateurEnCours=$entityManager->getRepository(User::class)->find($this->getUser()->getId());
//        dump($utilisateurEnCours);exit();
        if ($formSortie -> isSubmitted()) {
// Partie en travaux
            $sortie->setOrganisateur($utilisateurEnCours);
            $sortie->setSiteOrganisateur(
                $utilisateurEnCours->getSiteRattachement()

            );
            $sortie->setEtat(
                $this->getDoctrine()->getRepository(Etat::class)->find(1)
            );
//            dump($sortie->getOrganisateur());exit();
            //FIN de travaux
            $entityManager->persist($formSortie->getData());
            $entityManager->flush();
            $this->addFlash("success", "Sortie créée !");
            return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);
        }

        return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);

        }

    /**
     * @Route(name="inscription", path="inscription", methods={"GET", "POST"})
     */
    public function inscription(EntityManagerInterface $entityManager, Request $request){


        $utilisateurEnCours = $this->getUser();
        $sortie = $entityManager->getRepository(Sortie::class)->find($request->get('id'));
        $utilisateurEnCours->addSortiesInscrit($sortie);

        $entityManager->persist($utilisateurEnCours);
        $entityManager->flush();
        $this->addFlash("success","Inscription réussie ! ");

        return $this->redirectToRoute('sortie_mes_sorties');
    }

    /**
     * @Route(name="mes_sorties", path="mesSorties", methods={"GET", "POST"})
     */
    public function mes_sorties(EntityManagerInterface $entityManager, Request $request)
    {
        $sorties= $entityManager->getRepository('App:Sortie')->findAll();
        $utilisateurEnCours = $this->getUser();
        $sortieUser=$entityManager->getRepository(Sortie::class)->
        findBySortieUser($entityManager, $sorties, $utilisateurEnCours->getId());

        return $this->render('sortie/maliste.html.twig', ['mesSorties' => $sortieUser]);
    }
}