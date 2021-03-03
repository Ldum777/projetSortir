<?php


namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\SortieFormType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\SearchSiteType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route(name="sortie_", path="sortie/")
 */
class SortieController extends AbstractController
{
    /**
     *
     *
     * @Route(name="liste2", path="", methods={"GET", "POST"})
     * @Route(name="liste", path="liste", methods={"GET", "POST"})
     */
    public function sortie_liste(Request $request, EntityManagerInterface $manager)
    {
        $sorties= $manager->getRepository('App:Sortie')->findAll();
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
        //méthode qui enlève les sorties de plus d'un mois
        $sorties = $manager->getRepository(Sortie::class)->filtreUnMois($sorties);
        $sorties = $manager->getRepository(Sortie::class)->filtreEtat($sorties);
        return $this->render('sortie/liste.html.twig',
            ['sorties'=>$sorties,
                'mesSorties' => $sortieUser,
                'formSearchSite'=>$formSearchSite->createView()]);
    }

    /**
     * @Route(name="create", path="creer", methods={"GET", "POST"})
     *
     */
    public function create(EntityManagerInterface $entityManager, Request $request){
        $sortie = new sortie();

        if ($request->get('id')!=null){
            $sortie = $entityManager->getRepository(Sortie::class)->find($request->get('id'));

        }

        $formSortie = $this->createForm(SortieFormType::class, $sortie);


        $formSortie->handleRequest($request);


        /**
         * @var User
         */
        $utilisateurEnCours= $this->getUser();
        if ($formSortie -> isSubmitted() && $formSortie->isValid()) {

            $sortie->setOrganisateur($utilisateurEnCours);
            $sortie->addListeParticipant($utilisateurEnCours);
            $sortie->setNbInscriptionsMax($sortie->getNbInscriptionsMax()-1);
            $sortie->setSiteOrganisateur($utilisateurEnCours->getSiteRattachement());
            if($formSortie->getClickedButton()->getName() =="submit") {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(1));
                $this->addFlash("success", "Sortie publiée !");
            }
            else {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
                $sortie->setNbInscriptionsMax($sortie->getNbInscriptionsMax()+1);
                $this->addFlash("success", "Sortie créée !");
            }
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('sortie_mes_sorties');
//            return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);
        }

        return $this->render('sortie/create.html.twig', ['sortie'=>$sortie,'formSortie'=> $formSortie->createView()]);


        }

    /**
     * @Route(name="editer", path="editer/{id}", methods={"GET", "POST"})
     *
     */
    public function editer(EntityManagerInterface $entityManager, Request $request, Sortie $sortie ){


        $formSortie = $this->createForm(SortieFormType::class, $sortie);


        $formSortie->handleRequest($request);


        /**
         * @var User
         */
        $utilisateurEnCours= $this->getUser();
        if ($formSortie -> isSubmitted() && $formSortie->isValid()) {

            $sortie->setOrganisateur($utilisateurEnCours);
            $sortie->addListeParticipant($utilisateurEnCours);
            $sortie->setNbInscriptionsMax($sortie->getNbInscriptionsMax()-1);
            $sortie->setSiteOrganisateur($utilisateurEnCours->getSiteRattachement());

            if($formSortie->getClickedButton()->getName() =="submit") {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(1));
                $this->addFlash("success", "Sortie publiée !");
            }
            else {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
                $sortie->setNbInscriptionsMax($sortie->getNbInscriptionsMax()+1);
                $this->addFlash("success", "Sortie modifiée !");
            }
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('sortie_mes_sorties');
//            return $this->render('sortie/create.html.twig', ['formSortie'=> $formSortie->createView()]);
        }

        return $this->render('sortie/edit.html.twig', ['sortie'=>$sortie,'formSortie'=> $formSortie->createView()]);


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

        //Actualisation du nombre de places restantes
        $placesRestantes= $sortie->getNbInscriptionsMax()-1;
        $sortie->setNbInscriptionsMax($placesRestantes);
        $entityManager->persist($sortie);

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
        //méthode qui enlève les sorties de plus d'un mois
        $sortieUser = $entityManager->getRepository(Sortie::class)->filtreUnMois($sortieUser);

        return $this->render('sortie/maliste.html.twig', ['mesSorties' => $sortieUser]);
    }


    /**
     * @Route(name="se_desister", path="se_desister", methods={"GET", "POST"})
     */
    public function se_desister(Request $request, EntityManagerInterface $entityManager)
    {
        $utilisateurEnCours = $this->getUser();
        $sortie = $entityManager->getRepository(Sortie::class)->find($request->get('id'));
        $utilisateurEnCours->getSortiesInscrits();

        $utilisateurEnCours->removeSorty($sortie);
        $sortie->removeListeParticipant($utilisateurEnCours);
        $entityManager->persist($utilisateurEnCours);
        $entityManager->persist($sortie);


        $entityManager->flush();



        $placesRestantes= $sortie->getNbInscriptionsMax()+1;
        $sortie->setNbInscriptionsMax($placesRestantes);
        $entityManager->persist($sortie);

        $entityManager->flush();

        $this->addFlash("success","Vous avez été retiré de la sortie avec succès !");

        return $this->redirectToRoute('sortie_mes_sorties');
    }

    /**
     * @Route(name="annuler", path="annuler", methods={"GET", "POST"})
     */
    public function annuler(Request $request, EntityManagerInterface $entityManager)
    {
        $utilisateurEnCours = $this->getUser();
        $sortie = $entityManager->getRepository(Sortie::class)->find($request->get('id'));

        $utilisateurEnCours->getSortiesInscrits();

//        $utilisateurEnCours->removeSorty($sortie);
//        $sortie->removeListeParticipant($utilisateurEnCours);
        $etat = $entityManager->getRepository(Etat::class)->find(6);
        $sortie->setEtat($etat);
//        $entityManager->remove($sortie);


        $entityManager->persist($utilisateurEnCours);


        $entityManager->flush();



//        $placesRestantes= $sortie->getNbInscriptionsMax()+1;
//        $sortie->setNbInscriptionsMax($placesRestantes);
//        $entityManager->persist($sortie);
//
//        $entityManager->flush();

        $this->addFlash("success","Sortie annulée avec succès !");

        return $this->redirectToRoute('sortie_mes_sorties');
    }



//l'API' doit recevoir l'ID' de la ville et revoyer un tableau de lieu au format JSON
    /**
     * @Route(name="api_ville", path="api/villes/lieux/{id}", methods={"GET"})
     *
     */
    public function api_ville(Ville $ville, LieuRepository $lieuRepository, SerializerInterface $serializer){
        //le $ville dans le tableau réfère au paramètre de la fonction au-dessus
        $lieux = $lieuRepository->findBy(['ville'=>$ville]);
//        var_dump($lieux);
//        exit();


//        On utilise le serializer pour transformer me tableau d'objets en JSON
//        $var = $serializer->serialize($lieux, 'json'); Avant annotation Groups
        $var = $serializer->serialize($lieux, 'json', ['groups'=>['listeLieux']]);
        //Le tableau vide est si on veut mettre des entêtes
        //Le true signife que ce qu'on envoie est déjà en json
        return new JsonResponse($var, 200, [], true);
        //Ici on a : HTTP 500 Internal Server Error
        //A circular reference has been detected when serializing the object of class "App\Entity\Sortie" (configured limit: 1).
        //A cause des relations bidirectionnelles
        //Dans les entités Lieu et Ville, on doit dire quelles infos on veut sérializer, sinon il les prend toutes

    }
}