<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Origin;

class UsersControllerTest extends WebTestCase
{
    private $em;
    private $userManager;
    private $databaseUsers;
    private $origin;
    private $users = [
        [
            'username' => 'user1'
        ],
        [
            'username' => 'user2'
        ]
    ];

    public function __construct()
    {
        self::bootKernel();

        $this->databaseUsers = [];
        $this->origin = null;
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->userManager = static::$kernel->getContainer()->get('core.service.user');
    }

    private function insertOrigins()
    {
        $originTableName = $this->em->getClassMetadata('ApiBundle:Origin')->getTableName();
        $this->em->getConnection()->query('delete from '.$originTableName);
        $this->origin = new Origin();

        $this->origin->setName("my_origin");
        $this->em->persist($this->origin);
        $this->em->flush();
    }

    private function insertUsers()
    {
        foreach ($this->users as $key => $user) {
            $user['originId'] = $this->origin;
            $this->databaseUsers[] = $this->userManager->create($user);
        }
    }

    public function setUp()
    {
        $this->insertOrigins();
        $this->insertUsers();
    }

    public function testGetUsers()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');
        $result = json_decode($client->getResponse()->getContent());

        $this->assertCount(2, $result);
        foreach ($result as $key => $user) {
            $this->assertEquals($this->databaseUsers[$key]->getUsername(), $user->username);
        }
    }

    public function testGetUser()
    {
        $client = static::createClient();

        foreach ($this->databaseUsers as $key => $user) {
            $crawler = $client->request('GET', '/users/' . $this->databaseUsers[$key]->getId());
            $result = json_decode($client->getResponse()->getContent());

            $this->assertEquals($this->databaseUsers[$key]->getUsername(), $result->username);
        }
    }

    public function testPostUser()
    {
        $client = static::createClient();
        $newUsers = ['user_a', 'user_b', 'user_c', 'user_d'];

        foreach ($newUsers as $user) {
            $crawler = $client->request('POST', '/users', ['username' => $user, 'originId' => $this->origin->getId()]);
            $result = json_decode($client->getResponse()->getContent());

            $this->assertEquals($user, $result->username);
            $this->userManager->deleteUser($this->userManager->findUserBy(['id' => $result->id]));
        }
    }

    public function testDeleteUser()
    {
        $client = static::createClient();

        foreach ($this->databaseUsers as $databaseUser) {
            $crawler = $client->request('DELETE', '/users/' . $databaseUser->getId());

            $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
        }
    }

    public function testPatchUser()
    {
        $client = static::createClient();

        foreach ($this->databaseUsers as $databaseUser) {
            $newUsername = $databaseUser->getUsername() . '_edited';
            $crawler = $client->request('PATCH', '/users/' . $databaseUser->getId() . '?username=' . $newUsername);
            $result = json_decode($client->getResponse()->getContent());

            $this->assertEquals($result->username, $newUsername);
        }
    }

    private function purgeUsersDatabase()
    {
        foreach ($this->databaseUsers as $databaseUser) {
            $this->userManager->deleteUser($databaseUser);
        }
    }

    public function tearDown()
    {
        $this->purgeUsersDatabase();
        parent::tearDown();
    }
}
