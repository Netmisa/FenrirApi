<?php

namespace TyrSynchroBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;

class TyrEventConsumer implements ConsumerInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param UserManagerInterface $userManager
     * @param ObjectManager $om
     */
    public function __construct(UserManagerInterface $userManager, ObjectManager $om)
    {
        $this->userManager = $userManager;
        $this->om = $om;
    }

    /**
     * {@InheritDoc}
     *
     * Expected JSON message:
     * {"event": "create_user", "data": {...}}
     */
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->getBody());

        switch ($message->event) {
            case 'create_user':
                $user = $this->userManager->createUser();
                $this->updateUser($message->data, $user);
                break;

            case 'update_user':
                $user = $this->userManager->findUserByUsername($message->data->username);
                $this->updateUser($message->data, $user);
                break;

            case 'delete_user':
                $user = $this->userManager->findUserByUsername($message->data->username);
                $this->deleteUser($user);
                break;

            default:
                throw new \RuntimeException('Unknown event "'.$message->event.'"');
        }
    }

    /**
     * @param UserInterface $user
     */
    private function updateUser(\stdClass $data, UserInterface $user)
    {
        $originRepository = $this->om->getRepository('ApiBundle:Origin');

        $origin = $originRepository->findOneByName($data->origin->name);

        $user
            ->setUsername($data->login)
            ->setEmail($data->email)
            ->setOrigin($origin)
        ;

        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updateUser($user);
    }

    /**
     * @param UserInterface $user
     */
    private function deleteUser(UserInterface $user)
    {
        $this->userManager->deleteUser($user);
    }
}
