<?php

namespace ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Origin;

class OriginManager
{
    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('ApiBundle:Origin');
    }

    public function create($name)
    {
        $origin = new Origin();

        $origin->setName($name);
        $this->em->persist($origin);
        $this->em->flush();
        return $origin;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}
