<?php

namespace CoreBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use CoreBundle\Entity\Origin;
use CoreBundle\Form\OriginType;

class OriginController extends FOSRestController
{
    /**
     * Retrieve all origins.
     *
     * @param Origin $origin
     *
     * @return View
     */
    public function getOriginsAction()
    {
        $originRepository = $this->getDoctrine()->getRepository('CoreBundle:Origin');

        return View::create($originRepository->findAll());
    }

    /**
     * Retrieve one origin by id.
     *
     * @Rest\Route("/origins/{id}")
     *
     * @param Origin $origin
     *
     * @return View
     */
    public function getOriginAction(Origin $origin)
    {
        return View::create($origin);
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
        $origin = new Origin();
        $form = $this->createForm(OriginType::class, $origin);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->persist($origin);
                $em->flush();
            } catch (UniqueConstraintViolationException $e) {
                throw new ConflictHttpException($e->getMessage(), $e);
            }

            return View::create($origin->getId(), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param Request $request
     * @param Origin $origin
     *
     * @return View
     *
     * @throws ConflictHttpException
     */
    public function patchOriginsAction(Request $request, Origin $origin)
    {
        $form = $this->createForm(OriginType::class, $origin);

        $form->submit($request->request->get('origin'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->flush();
            } catch (UniqueConstraintViolationException $e) {
                throw new ConflictHttpException($e->getMessage(), $e);
            }

            return View::create(null, Response::HTTP_NO_CONTENT);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param Origin $origin
     *
     * @return View
     */
    public function deleteOriginsAction(Origin $origin)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($origin);
        $em->flush();

        return View::create($origin->getId(), Response::HTTP_OK);
    }
}
