<?php

namespace TyrSynchroBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use ApiBundle\Service\OriginManager;
use ApiBundle\Entity\Origin;

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
            case 'create_end_point':
                $origin = $this->originManager->create($message->data->name);
                break;
            case 'update_end_point':
                $origin = $this->originManager->findOneByName($message->data->last_name);
                $this->updateOrigin($message->data, $origin);
                break;
            case 'delete_end_point':
                $origin = $this->originManager->findOneByName($message->data->name);
                $this->deleteOrigin($origin);
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
        $origin = $this->originManager->findOneByName($data->origin->name);

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

    /**
     * @param Origin $origin
     */
    private function updateOrigin(\stdClass $data, Origin $origin)
    {
        $origin->setName($data->name);

        $this->originManager->update($origin);
    }

    /**
     * @param Origin $origin
     */
    private function deleteOrigin(Origin $origin)
    {
        $this->originManager->remove($origin);
    }
}
