<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SearchSiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile", name="profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/monprofil", name="display")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/modifier", name="edit", methods={"GET", "POST"})
     */
    public function edit(UserPasswordEncoderInterface $encoder, Request $request, EntityManagerInterface $entityManager){

        $utilisateurEnCours= $this->getUser();
        $utilisateurEnCours=$entityManager->getRepository(User::class)->find($this->getUser()->getId());

        $form = $this->createForm('App\Form\EditProfileFormType', $utilisateurEnCours);
        $form->handleRequest($request);
        //dd($form->getErrors());


        if ($form->isSubmitted() && $form->isValid()) {
            //dump($form);
            //exit();
            $pseudo = $form->get('pseudo')->getData();
            $test = preg_match('/[\\/^£$%&*\'()}{"@#~?><,|=+¬]/', $pseudo);
            if($test != 0){
                $this->addFlash('danger', 'Pseudo invalide, veuillez recommencer.');
                return $this -> redirectToRoute('profile_display');
            };
            $password = $form->get('plainPassword')->getData();
            if($password != null) {
                $password = $encoder->encodePassword($utilisateurEnCours, $utilisateurEnCours->getPlainPassword());
                $utilisateurEnCours->setPassword($password);
            }
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été modifié avec succès !');
            return $this->redirectToRoute('profile_display', ['id' => $utilisateurEnCours->getId()]);
        }
        return $this->render('profile/edit.html.twig', ['formEdit' => $form->createView()]);
    }

    /**
     * @Route("/details", name="details", methods={"GET"})
     */
    public function details(Request $request, EntityManagerInterface $entityManager)
    {
        $id = $request->get('id');
        $user = $entityManager->getRepository('App:User')->getById($id);

        return $this->render('profile/details.html.twig', ['user' => $user]);
    }

    /**
     * @Route(name="liste", path="/liste", methods={"GET", "POST"})
     */
    public function user_liste(Request $request, EntityManagerInterface $manager)
    {
//        $users= $manager->getRepository('App:User')->findAll();

        $sortie = $manager->getRepository(Sortie::class)->find($request->get('id'));

        $users = $sortie->getListeParticipants();
        //Chargement des catégories
//        $formSearchSite = $this->createForm(SearchSiteType::class);
//        $formSearchSite->handleRequest($request);
//
//        if($formSearchSite->isSubmitted() && $formSearchSite->isValid()){
//            //Préparation du filtre pour ne pas afficher le bouton Inscription pour les sorties auxquelles on est déjà isncrit
//            $utilisateurEnCours = $this->getUser();
//            $sortieUser=$manager->getRepository(Sortie::class)->
//            findBySortieUser($manager, $sorties, $utilisateurEnCours->getId());
//
//            $site = $formSearchSite->get('site')->getData();
//            $sortiesSite=$manager->getRepository(Sortie::class)->findBySite($manager, $site);
//            return $this->render('sortie/liste.html.twig', ['sorties'=>$sortiesSite, 'mesSorties' => $sortieUser, 'formSearchSite'=>$formSearchSite->createView()]);
//        }
//
//        //Préparation du filtre pour ne pas afficher le bouton Inscription pour les sorties auxquelles on est déjà isncrit
//        $utilisateurEnCours = $this->getUser();
//
//        $sortieUser=$manager->getRepository(Sortie::class)->
//        findBySortieUser($manager, $sorties, $utilisateurEnCours->getId());

        return $this->render('sortie/listeUser.html.twig',
            ['users'=>$users]);
    }
}
