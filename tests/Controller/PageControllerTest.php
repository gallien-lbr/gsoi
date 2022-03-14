<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    // Ecriture d'un test fonctionnel
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET','/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1','Site index');
    }
}