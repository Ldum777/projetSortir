<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {


        $site = new Site();
        $site->setNom("Nantes");
        $manager->persist($site);

        $site2 = new Site();
        $site2->setNom("Angers");
        $manager->persist($site2);

        $site3 = new Site();
        $site3->setNom("Rennes");
        $manager->persist($site3);

        $site4 = new Site();
        $site4->setNom("Niort");
        $manager->persist($site4);

        $site5 = new Site();
        $site5->setNom("Quimper");
        $manager->persist($site5);



        $userAdmin = new User();
        $userAdmin->setPrenom("AdminName")
                ->setNom("AdminSurname")
                ->setTelephone("0606060606")
                ->setAdministrateur(1)
                ->setActif(1)
                ->setPassword( '$argon2id$v=19$m=65536,t=4,p=1$cE9ZT1JmOGkvTFB0UW9YdA$CQP0WXtOBHko0vvDGy3Zwwfveecdrj1qSHoBUkT56xc' )
                ->setEmail("admin@defaut.com")
                ->setSiteRattachement($site)
                ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($userAdmin);
        $userBis = new User();
        $userBis->setNom("UserDefaultSurname N°bis")
            ->setPrenom("UserDefaultName N°bis")
            ->setTelephone("0606060606")
            ->setAdministrateur(0)
            ->setActif(1)
            ->setPassword( '$argon2id$v=19$m=65536,t=4,p=1$cE9ZT1JmOGkvTFB0UW9YdA$CQP0WXtOBHko0vvDGy3Zwwfveecdrj1qSHoBUkT56xc')
            ->setEmail("utilisateurbis"."@defaut.com")
            ->setSiteRattachement($site)
            ->setRoles(["ROLE_USER"]);

        $manager->persist($userBis);

        for ($i=1; $i <= 5; $i++) {
            $user = new User();
            $user->setNom("UserDefaultSurname N°".$i)
                ->setPrenom("UserDefaultName N°".$i)
                ->setTelephone("0606060606")
                ->setAdministrateur(0)
                ->setActif(1)
                ->setPassword( '$argon2id$v=19$m=65536,t=4,p=1$cE9ZT1JmOGkvTFB0UW9YdA$CQP0WXtOBHko0vvDGy3Zwwfveecdrj1qSHoBUkT56xc')
                ->setEmail("utilisateur".$i."@defaut.com")
                ->setSiteRattachement($site)
                ->setRoles(["ROLE_USER"]);

            $manager->persist($user);
        }
        for ($i=6; $i <= 10; $i++) {
            $user = new User();
            $user->setNom("UserDefaultSurname N°".$i)
                ->setPrenom("UserDefaultName N°".$i)
                ->setTelephone("0606060606")
                ->setAdministrateur(0)
                ->setActif(1)
                ->setPassword( '$argon2id$v=19$m=65536,t=4,p=1$cE9ZT1JmOGkvTFB0UW9YdA$CQP0WXtOBHko0vvDGy3Zwwfveecdrj1qSHoBUkT56xc')
                ->setEmail("utilisateur".$i."@defaut.com")
                ->setSiteRattachement($site2)
                ->setRoles(["ROLE_USER"]);

            $manager->persist($user);
        }
        for ($i=11; $i <= 15; $i++) {
            $user = new User();
            $user->setNom("UserDefaultSurname N°".$i)
                ->setPrenom("UserDefaultName N°".$i)
                ->setTelephone("0606060606")
                ->setAdministrateur(0)
                ->setActif(1)
                ->setPassword( '$argon2id$v=19$m=65536,t=4,p=1$cE9ZT1JmOGkvTFB0UW9YdA$CQP0WXtOBHko0vvDGy3Zwwfveecdrj1qSHoBUkT56xc')
                ->setEmail("utilisateur".$i."@defaut.com")
                ->setSiteRattachement($site3)
                ->setRoles(["ROLE_USER"]);

            $manager->persist($user);
        }
        $etat= new Etat();
        $etat->setLibelle("Ouverte");
        $manager->persist($etat);
        $lieu= new Lieu();
        $lieu->setNom("Intra-Muros");
        $ville=new Ville();
        $ville->setNom("Saint-Malo")
        ->setCodePostal("35400");
        $lieu->setVille($ville);

        $manager->persist($ville);
        $manager->persist($lieu);


        $lieu = new Lieu();
        $lieu->setNom("Icepark Angers");
        $lieu->setVille($ville);

        $manager->persist($lieu);

        $lieu2 = new Lieu();
        $lieu2->setNom("Parc Balzac");
        $lieu2->setVille($ville);
        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom("Intra-Muros");
        $lieu3->setVille($ville);
        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNom("Le Port");
        $lieu4->setVille($ville);
        $manager->persist($lieu4);

        $lieu5 = new Lieu();
        $lieu5->setNom("Miroir d'eau");
        $lieu5->setVille($ville);
        $manager->persist($lieu5);


        $etat = new Etat();
        $etat->setLibelle("Créée");
        $manager->persist($etat);

        $etat3 = new Etat();
        $etat3->setLibelle("Clôturée");
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle("Activité en cours");
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle("Passée");
        $manager->persist($etat5);

        $etat6 = new Etat();
        $etat6->setLibelle("Annulée");
        $manager->persist($etat6);





        $ville2=new Ville();
        $ville2->setNom("Nantes")
            ->setCodePostal("44200");
        $manager->persist($ville2);
        $ville3=new Ville();
        $ville3->setNom("Rennes")
            ->setCodePostal("35000");
        $manager->persist($ville3);
        $ville4=new Ville();
        $ville4->setNom("Angers")
            ->setCodePostal("49100");
        $manager->persist($ville4);


        for ($i=1; $i <= 3; $i++) {
            //Préparation de la date
            $date = new DateTime("now");
            $date->add(new DateInterval("P".$i."D"));

            $sortie = new Sortie();
            $sortie->setNom("Vamos a la playa N°".$i)
                ->setDateHeureDebut(new \DateTime("now"))
                ->setDuree(240)
                ->setDateLimiteInscription($date)
                ->setNbInscriptionsMax($i)
                ->setInfosSortie("on va se promener bande de couillons")
                ->setEtat($etat)
                ->setLieu($lieu)
                ->setOrganisateur($user)
                ->setSiteOrganisateur($site)
                ->addListeParticipant($user)
                ;

            $manager->persist($sortie);

        }
        for ($i=4; $i <= 5; $i++) {
            //Préparation de la date
            $date = new DateTime("now");
            $date->add(new DateInterval("P".$i."D"));

            $sortie = new Sortie();
            $sortie->setNom("Vamos a la playa N°".$i)
                ->setDateHeureDebut(new \DateTime("now"))
                ->setDuree(240)
                ->setDateLimiteInscription($date)
                ->setNbInscriptionsMax(0)
                ->setInfosSortie("on va se promener bande de couillons")
                ->setEtat($etat)
                ->setLieu($lieu)
                ->setOrganisateur($user)
                ->setSiteOrganisateur($site)
                ->addListeParticipant($user)
            ;

            $manager->persist($sortie);

        }
        for ($i=6; $i <= 7; $i++) {
            //Préparation de la date
            $date = new DateTime("now");
            $date->sub(new DateInterval("P".$i."D"));

            $sortie = new Sortie();
            $sortie->setNom("Vamos a la playa N°".$i)
                ->setDateHeureDebut(new \DateTime("now"))
                ->setDuree(240)
                ->setDateLimiteInscription($date)
                ->setNbInscriptionsMax($i-6)
                ->setInfosSortie("on va se promener bande de couillons")
                ->setEtat($etat)
                ->setLieu($lieu2)
                ->setOrganisateur($user)
                ->setSiteOrganisateur($site2)
                ->addListeParticipant($user);

            $manager->persist($sortie);

        }
        for ($i=8; $i <= 10; $i++) {
            //Préparation de la date
            $date = new DateTime("now");
            $date->sub(new DateInterval("P".$i."D"));

            $sortie = new Sortie();
            $sortie->setNom("Vamos a la playa N°".$i)
                ->setDateHeureDebut(new \DateTime("now"))
                ->setDuree(240)
                ->setDateLimiteInscription($date)
                ->setNbInscriptionsMax($i-6)
                ->setInfosSortie("on va se promener bande de couillons")
                ->setEtat($etat)
                ->setLieu($lieu2)
                ->setOrganisateur($user)
                ->setSiteOrganisateur($site2)
                ->addListeParticipant($userBis);

            $manager->persist($sortie);

        }
        for ($i=11; $i <= 13; $i++) {
        $sortie = new Sortie();
        $sortie->setNom("Vamos a la playa N°".$i)
            ->setDateHeureDebut(new \DateTime("now"))
            ->setDuree(240)
            ->setDateLimiteInscription(new \DateTime("now"))
            ->setNbInscriptionsMax($i-11)
            ->setInfosSortie("on va se promener bande de couillons")
            ->setEtat($etat6)
            ->setLieu($lieu3)
            ->setOrganisateur($userBis)
            ->setSiteOrganisateur($site3)
            ->addListeParticipant($userBis);

        $manager->persist($sortie);

        }

        for ($i=14; $i <= 15; $i++) {
            $sortie = new Sortie();
            $sortie->setNom("Vamos a la playa N°".$i)
                ->setDateHeureDebut(new \DateTime('2021-01-14'))
                ->setDuree(240)
                ->setDateLimiteInscription(new \DateTime("now"))
                ->setNbInscriptionsMax($i-11)
                ->setInfosSortie("on va se promener bande de couillons")
                ->setEtat($etat6)
                ->setLieu($lieu3)
                ->setOrganisateur($userBis)
                ->setSiteOrganisateur($site3)
                ->addListeParticipant($userBis);

            $manager->persist($sortie);

        }




        $manager->flush();
    }





}