<?php

namespace ApiBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use ApiBundle\Entity\Origin;

class OriginsController extends FOSRestController
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
        $originRepository = $this->getDoctrine()->getRepository('ApiBundle:Origin');

        return View::create($originRepository->findAll());
    }

    /**
     * Retrieve one origin by id.
     *
     * @Rest\Route("/origins/{id_or_name}", requirements={"id_or_name": ".+"})
     * @ParamConverter("origin", class="ApiBundle:Origin", options={
     *      "repository_method" = "findByIdOrName",
     *      "id": "id_or_name"
     * })
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
     * @Rest\RequestParam(name="name", requirements="[a-z_\.]+")
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return View id of the created origin.
     *
     * @throws ConflictHttpException If name (unique) already exists.
     */
    public function postOriginsAction(ParamFetcher $paramFetcher)
    {
        $origin = new Origin();
        $origin->setName($paramFetcher->get('name'));

        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($origin);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictHttpException($e->getMessage(), $e);
        }

        return View::create($origin->getId(), Response::HTTP_CREATED);
    }

    /**
     * @Rest\RequestParam(name="name", requirements="[a-z_\.]+")
     *
     * @param ParamFetcher $paramFetcher
     * @param Origin       $origin
     *
     * @return View
     *
     * @throws ConflictHttpException
     */
    public function patchOriginsAction(ParamFetcher $paramFetcher, Origin $origin)
    {
        $origin->setName($paramFetcher->get('name'));

        $em = $this->getDoctrine()->getManager();

        try {
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictHttpException($e->getMessage(), $e);
        }

        return View::create($origin, Response::HTTP_OK);
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
