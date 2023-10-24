<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 *
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

/*
 * Retourne toutes les visites triées sur un champ
 * @param type $champ
 * @param type $ordre
 * @return Visite[]
 */
    
public function findAllOrderBy($champ, $ordre): array{
    return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, $ordre)
                ->getQuery()
                ->getResult();
    
}    

/**
 * Recherche des enregistrements en fonction d'un champ et d'une valeur, sans suivre la convention de nommage standard.
 *
 * @param string $champ Le nom du champ sur lequel effectuer la recherche.
 * @param mixed $valeur La valeur à rechercher.
 * @return array Les enregistrements correspondants.
 */
public function findEqualValue($champ, $valeur) : array {
    if ($valeur==""){
        return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ.'ASC')
                ->getQuery()
                ->getResult();
        }else{
            return $this->createQueryBuilder('v')
                    ->where('v.'.$champ.'=:valeur')
                    ->setParameter('valeur', $valeur)
                    ->orderBy('v.datecreation','DESC')
                    ->getQuery()
                    ->getResult();
        } 
        
}
    
public function remove(Visite $visite){
    $this->_em->remove($visite);
    $this->_em->flush();
}
      
        
    }
    



//    /**
//     * @return Visite[] Returns an array of Visite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Visite
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

