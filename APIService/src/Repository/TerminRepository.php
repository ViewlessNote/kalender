<?php

namespace App\Repository;
use App\Entity\Termin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Termin>
 */
class TerminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, Termin::class);
    }
    public function setNewTermin(termin $termin){
        $this->em->persist($termin);
        $this->em->flush();
    }
    public function getTermin(int $id){
        return$this->find($id);
    }
    public function getTermine(){
        return $this->em->getRepository(Termin::class)->findAll();
    }
    public function deleteTermin(int $id){
        $this->em->remove($this->getTermin($id));
        $this->em->flush();
    }
    public function updateTermin(int $id, termin $termin){
        $this->em->persist($this->getTermin($id));
        $this->em->flush();
    }


    //    /**
    //     * @return Termin[] Returns an array of Termin objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Termin
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
