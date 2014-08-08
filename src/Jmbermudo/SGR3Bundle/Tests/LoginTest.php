<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array(), array('DOCUMENT_ROOT' => '/', 'HTTP_HOST' => 'www.mysgr3.com'));
        //$this->client->followRedirects(true);
    }
    
    public function testOKLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Entrar')->form(array(
            '_username' => 'jose',
            '_password' => 'amarillo',
        ));
        $this->client->submit($form);
        
        $response = $this->client->getResponse();
        
        $this->assertTrue($response->isRedirect('http://www.mysgr3.com/personal'), "El login salio mal");
    }
    
    public function testFailLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Entrar')->form(array(
            '_username' => 'fail',
            '_password' => 'fail',
        ));
        $this->client->submit($form);
        
        $response = $this->client->getResponse();
        #Al ser un login fallido, la redirección debe ser de nuevo a login
        $this->assertTrue($response->isRedirect('http://www.mysgr3.com/login'), "El login funcionó, y no debería haberlo hecho");
    }


}
