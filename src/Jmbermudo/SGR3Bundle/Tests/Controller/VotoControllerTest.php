<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VotoControllerTest extends WebTestCase
{
    public function testVotacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/votacion');
    }

    public function testModificarvotacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modificarVotacion');
    }

}
