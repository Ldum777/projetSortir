<?php

namespace App\Controller;

use App\Entity\User;
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
            $password=$encoder->encodePassword($utilisateurEnCours, $utilisateurEnCours->getPlainPassword());
            $utilisateurEnCours->setPassword($password);
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

}
