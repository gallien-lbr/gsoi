<?php

declare(strict_types=1);
namespace App\Tests\Controller;

use App\Entity\Link;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional tests against API Endpoints
 */
final class LinkControllerTest extends WebTestCase
{
    private const BASE_URL = '/api/v1/link';
    private const API_SAVE = self::BASE_URL . '/save';
    private const API_DELETE = self::BASE_URL . '/delete';
    private const API_GET = self::BASE_URL . '/list';
    private const URL = 'https://www.youtube.com/watch?v=6IUeFk0pyAA';

    private ?KernelBrowser $client;
    private ?EntityManager $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        // doing this is recommanded to avoir memory leaks
        $this->client = null;
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSaveSuccessful(): void
    {
        // act
        $crawler = $this->client->request('POST', self::API_SAVE, [], [], [], \json_encode(['url' => self::URL]));

        // assert
        $this->assertResponseIsSuccessful(\sprintf('%s test', self::API_SAVE));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testSaveFail(): void
    {
        // act
        $crawler = $this->client->request('POST', self::API_SAVE, [], [], [], \json_encode(['url' => null]));

        // assert
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, sprintf('%s test', self::API_SAVE));
    }

    public function testDeleteSuccessful(): void
    {
        // arrange
        $link = $this->entityManager
            ->getRepository(Link::class)
            ->findOneBy([], ['id' => 'desc']);

        // act
        $crawler = $this->client->request('DELETE', self::API_DELETE, [], [], [], \json_encode(['id' => $link->getId()]));

        // assert
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteFail(): void
    {
        // act
        $crawler = $this->client->request('DELETE', self::API_DELETE, [], [], [], \json_encode(['id' => null]));

        // assert
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testListSuccessful():void
    {
        // act
        $this->client->request('GET', self::API_GET);

        // assert
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}