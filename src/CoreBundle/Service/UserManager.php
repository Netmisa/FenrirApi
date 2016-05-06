<?php

namespace CoreBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use CoreBundle\Entity\User;

class UserManager extends BaseUserManager
{
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);
    }

    public function create(array $data)
    {
        $user = $this->createUser();

        if (array_key_exists('username', $data)) {
            $user->setUsername($data['username']);
        }
        if (array_key_exists('enabled', $data)) {
            $user->setEnabled($data['enabled'] == 1 ? true : false);
        }
        if (array_key_exists('locked', $data)) {
            $user->setLocked($data['locked'] == 1 ? true : false);
        }
        if (array_key_exists('expired', $data)) {
            $user->setExpired($data['expired'] == 1 ? true : false);
        }
        if (array_key_exists('credentials_expired', $data)) {
            $user->setCredentialsExpired($data['credentials_expired'] == 1 ? true : false);
        }
        if (array_key_exists('email', $data)) {
            $user->setEmail($data['email']);
        }
        if (array_key_exists('password', $data)) {
            $user->setPlainPassword($data['password']);
        }
        $user = $this->objectManager->persist($user);
        $this->objectManager->flush();
        return $user;
    }
}
