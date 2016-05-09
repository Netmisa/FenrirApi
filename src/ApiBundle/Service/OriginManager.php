<?php

namespace ApiBundle\Service;

use Doctrine\ORM\EntityManager;

class OriginManager
{
    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('ApiBundle:Origin');
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
