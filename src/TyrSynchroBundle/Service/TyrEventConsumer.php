<?php

namespace TyrSynchroBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use ApiBundle\Service\OriginManager;

class TyrEventConsumer implements ConsumerInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var OriginManager
     */
    private $originManager;

    /**
     * @param UserManagerInterface $userManager
     * @param ObjectManager        $om
     */
    public function __construct(UserManagerInterface $userManager, OriginManager $originManager)
    {
        $this->userManager = $userManager;
        $this->originManager = $originManager;
    }

    /**
     * {@inheritdoc}
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
                $user = $this->userManager->findUserByUsername($message->data->last_username);
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
        $origin = $this->originManager->findOrCreateByName($data->origin->name);

        $user
            ->setUsername($data->username)
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
