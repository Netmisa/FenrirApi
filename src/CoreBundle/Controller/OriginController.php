<?php

namespace CoreBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use CoreBundle\Entity\Origin;
use CoreBundle\Form\OriginType;

class OriginController extends FOSRestController
{
    /**
     * Retrieve all origins.
     *
     * @return View
     */
    public function getOriginsAction()
    {
        $origins = $this->getDoctrine()
            ->getRepository('CoreBundle:Origin')
            ->findAll()
        ;

        return View::create($origins);
    }

    /**
     * @param Request $request
     *
     * @return View id of the created origin.
     *
     * @throws ConflictHttpException If name (unique) already exists.
     */
    public function postOriginsAction(Request $request)
    {
        $entity = new Origin();
        $form = $this->createForm(OriginType::class, $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->persist($entity);
                $em->flush();
            } catch (UniqueConstraintViolationException $e) {
                throw new ConflictHttpException($e->getMessage(), $e);
            }

            return View::create($entity->getId(), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
