<?php

namespace App\Repository;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findBySite(EntityManagerInterface $em, Site $site){
        return $this->createQueryBuilder('s')
            ->andWhere('s.siteOrganisateur = :site')
            ->setParameter('site', $site)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySortieUser(EntityManagerInterface $em, $sortie, $userId){
        return $this->createQueryBuilder('s')
//            ->Where('sortie.id = :$sortieId')

                //On cherche si l'utilisateur est membre des participants
                //On pourrait aussi utiliser NOT MEMBER OF
                //les WHERE écrase les restrictions précédentes, alors que le andWhere
                //ajotue une condition
                //Il existe aussi le orWhere

            ->andWhere(':user MEMBER OF s.listeParticipants')
            ->setParameter('user', $userId)
//            ->orderBy('s.$userId', 'ASC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;

//        SELECT *
//        FROM table1
//INNER JOIN table2
//WHERE table1.id = table2.fk_id
//        ->select('u.id', 'u.name', 'p.number')
//            ->from('users', 'u')
//            ->innerJoin('u', 'phonenumbers', 'p', 'u.id = p.user_id')
//
//            ->select('COUNT(gu.group) teamLength', 'g.departure departure')
//            ->innerJoin('AppBundle:GroupUser', 'gu', Join::WITH, 'g.id = gu.group')
//            ->andWhere('g.itinerary = :itineraryId')
//            ->setParameter('itineraryId', $itinerary->getId())
//            ->andWhere('g.departure BETWEEN :firstDate AND :lastDate')
//            ->setParameter('firstDate', $firstDate->format('Y-m-d'))
//            ->setParameter('lastDate', $lastDate->format('Y-m-d'));
    }
    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function filtreUnMois(array $sorties)
    {

        $sortiesRetournees = [];

        $unMoisAvant= new DateTime('now');
        $unMoisAvant->sub(new \DateInterval('P1M'));

        foreach ($sorties as $sortie) {

            if($sortie->getDateHeureDebut() > $unMoisAvant){
                $sortiesRetournees[]=$sortie;
            }
        }
        return $sortiesRetournees;
    }
}
