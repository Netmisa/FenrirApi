<?php

namespace Tests\ApiBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiBundle\Entity\Origin;

class OriginsControllerTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    private $origins;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        $this->origins = [];
    }

    /**
     * {@InheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $originTableName = $this->em->getClassMetadata('ApiBundle:Origin')->getTableName();
        $this->em->getConnection()->query('delete from '.$originTableName);

        $this->origins[] = new Origin();
        $this->origins[0]->setName('navitia.io');

        $this->origins[] = new Origin();
        $this->origins[1]->setName('sncf');

        $this->em->persist($this->origins[0]);
        $this->em->persist($this->origins[1]);
        $this->em->flush();
    }

    public function testGetOriginsReturnsExpectedStructure()
    {
        $client = static::createClient();

        $client->request('GET', '/origins');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'get origins returns a successful status code');

        $response = json_decode($client->getResponse()->getContent());

        $this->assertInternalType('array', $response);
        $this->assertCount(2, $response);
        $this->assertObjectHasAttribute('name', $response[0]);
        $this->assertEquals('navitia.io', $response[0]->name);
    }

    public function testGetOriginReturnsOneOrigin()
    {
        $client = static::createClient();

        $client->request('GET', '/origins');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'get origins returns a successful status code');

        $originsResponse = json_decode($client->getResponse()->getContent());

        $firstOrigin = array_shift($originsResponse);

        $client->request('GET', '/origins/'.$firstOrigin->id);

        $response = json_decode($client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $response);
        $this->assertObjectHasAttribute('name', $response);
        $this->assertEquals($firstOrigin->id, $response->id);
        $this->assertEquals($firstOrigin->name, $response->name);
    }

    public function testPostOrigin()
    {
        $client = static::createClient();

        $client->request('POST', '/origins', [
            'name' => 'my_new_origin',
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $createdOriginId = json_decode($client->getResponse()->getContent());

        $this->assertInternalType('int', $createdOriginId);

        $client->request('GET', '/origins/'.$createdOriginId);

        $createdOrigin = json_decode($client->getResponse()->getContent());

        $this->assertEquals($createdOriginId, $createdOrigin->id);
        $this->assertEquals('my_new_origin', $createdOrigin->name);
    }

    public function testPatchOrigin()
    {
        $client = static::createClient();

        $client->request('PATCH', '/origins/' . $this->origins[0]->getId(), [
            'name' => 'navitia.io_updated',
        ]);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'patch origins returns a successful status code');

        $origin = json_decode($client->getResponse()->getContent());

        $this->assertEquals('navitia.io_updated', $origin->name);
    }

    public function testDeleteOrigin()
    {
        $client = static::createClient();

        $client->request('DELETE', '/origins/' . $this->origins[0]->getId());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'patch origins returns a successful status code');

        $client->request('GET', '/origins/1');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
