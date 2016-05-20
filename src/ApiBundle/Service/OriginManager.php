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

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findOrCreateByName($name)
    {
        $origin = $this->repository->findOneByName($name);

        if (is_null($origin)) {
            $origin = new Origin();

            $origin->setName($name);
            $this->em->persist($origin);
            $this->em->flush();
        }
        return $origin;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}
