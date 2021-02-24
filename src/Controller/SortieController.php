<?php


namespace App\Controller;


use App\Entity\Sortie;
use App\Form\SearchSiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route(name="home_", path="/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route(name="sortie_liste", path="/liste", methods={"GET", "POST"})
     */
    public function sortie_liste(Request $request, EntityManagerInterface $manager)
    {
        $sorties[]= $manager->getRepository('App:Sortie')->findAll();
        //CHANGER la fonction findAll, elle retour un tableau de tableaux

        //Chargement des catégories
        $formSearchSite = $this->createForm(SearchSiteType::class);
        $formSearchSite->handleRequest($request);

        if($formSearchSite->isSubmitted() && $formSearchSite->isValid()){
            $site = $formSearchSite->get('site')->getData();
            $sortiesSite[]=$manager->getRepository(Sortie::class)->findBySite($manager, $site);
            return $this->render('sortie/liste.html.twig', ['sorties'=>$sortiesSite[0], 'formSearchSite'=>$formSearchSite->createView()]);
        }
//        $lieu = $manager->getRepository('App:Lieu')->find(2);

        return $this->render('sortie/liste.html.twig', ['sorties'=>$sorties[0], 'formSearchSite'=>$formSearchSite->createView()]);
    }

}