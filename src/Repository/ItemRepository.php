<?php

namespace App\Repository;

use App\Entity\ProduceItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ItemRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, ProduceItem::class);
    }

    public function getShoppingListItems() {
        return $this->getEntityManager()
            ->createQuery('SELECT item FROM App\Entity\ProduceItem item WHERE item.name = :name')
            //->setParameter('name', 'carrot')
            ->getResult();
    }

    public function getRefrigeratorItems() {
        return $this->getEntityManager()
            ->createQuery('SELECT item FROM App\Entity\ProduceItem item WHERE item.name = :name')
            //->setParameter('name', 'carrot')
            ->getResult();
    }
}