<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VotoControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array(), array('DOCUMENT_ROOT' => '/', 'HTTP_HOST' => 'www.mysgr3.com'));
    }
    
    public function testVotacion()
    {
        $this->doLogin();
        
        $crawler = $this->client->request('GET', '/votacion/votar/13');
        
//        $response = $this->client->getResponse();
//        echo $response;
        
        $form = $crawler->selectButton('Votar')->form();
        
        $form['form[voto_10_1]']->tick();
        
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $response = $this->client->getResponse();
        echo $response;
        
        $this->assertGreaterThan(0, $crawler->filter('h4:contains("Tu votación ha sido registrada correctamente")')->count(), 'El voto no se ha registrado correctamente');
        
    }

    private function doLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Entrar')->form(array(
            '_username' => 'jose',
            '_password' => 'amarillo',
        ));
        $this->client->submit($form);
    }

}
