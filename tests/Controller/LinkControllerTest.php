<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LinkControllerTest extends WebTestCase
{
    private const API_SAVE = '/api/v1/link/save';
    private const URL = 'https://www.youtube.com/watch?v=6IUeFk0pyAA';
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testSaveSuccessful()
    {
        $crawler = $this->client->request('POST', self::API_SAVE, [], [], [], \json_encode(['url' => self::URL]));
        $this->assertResponseIsSuccessful(\sprintf('%s test', self::API_SAVE));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testSaveFail()
    {
        $crawler = $this->client->request('POST', self::API_SAVE, [], [], [], \json_encode(['url' => null]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, sprintf('%s test', self::API_SAVE));
    }
}