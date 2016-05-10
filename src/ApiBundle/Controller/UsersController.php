<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use ApiBundle\Entity\User;

class UsersController extends FOSRestController
{
    public function getUsersAction()
    {
        $users = $this->get('core.service.user')->findUsers();

        return $this->handleView($this->view($users));
    }

    public function getUserAction(User $user)
    {
        return $this->handleView($this->view($user));
    }

    public function deleteUserAction(User $user)
    {
        $this->get('core.service.user')->deleteUser($user);

        return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
    }

    /**
     * @RequestParam(name="username", requirements="[a-z_0-9]+", strict=true)
     * @RequestParam(name="originId", requirements="[0-9]+", strict=true)
     * @RequestParam(name="enabled", requirements="[0|1]", nullable=true)
     * @RequestParam(name="locked", requirements="[0|1]", nullable=true)
     * @RequestParam(name="expired", requirements="[0|1]", nullable=true)
     * @RequestParam(name="roles", map=true, requirements="[A-Z_]+", nullable=true)
     * @RequestParam(name="credentials_expired", requirements="[0|1]", nullable=true)
     * @RequestParam(name="email", requirements="[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,6}", nullable=true)
     * @RequestParam(name="password", requirements="[a-z0-9]+", nullable=true)
     */
    public function postUsersAction(ParamFetcherInterface $paramFetcher)
    {
        $user = $this->get('core.service.user')->create($paramFetcher->all());

        return $this->handleView($this->view($user, Response::HTTP_CREATED));
    }

    /**
     * @RequestParam(name="username", requirements="[a-z_0-9]+", nullable=true)
     * @RequestParam(name="originId", requirements="[0-9]+", nullable=true)
     * @RequestParam(name="enabled", requirements="[0|1]", nullable=true)
     * @RequestParam(name="locked", requirements="[0|1]", nullable=true)
     * @RequestParam(name="expired", requirements="[0|1]", nullable=true)
     * @RequestParam(name="roles", map=true, requirements="[A-Z_]+", nullable=true)
     * @RequestParam(name="credentials_expired", requirements="[0|1]", nullable=true)
     * @RequestParam(name="email", requirements="[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,6}", nullable=true)
     * @RequestParam(name="password", requirements="[a-z0-9]+", nullable=true)
     */
    public function patchUserAction(ParamFetcherInterface $paramFetcher, User $user)
    {
        $user = $this->get('core.service.user')->update($user, $paramFetcher->all());

        return $this->handleView($this->view($user));
    }
}
