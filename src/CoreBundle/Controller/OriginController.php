<?php

namespace CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class OriginController extends FOSRestController
{
    public function getOriginsAction()
    {
        $origins = $this->getDoctrine()
            ->getRepository('CoreBundle:Origin')
            ->findAll()
        ;

        return $origins;
    }
}
