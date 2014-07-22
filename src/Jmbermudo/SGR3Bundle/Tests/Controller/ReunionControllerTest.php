<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ReunionControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array(), array('DOCUMENT_ROOT' => '/', 'HTTP_HOST' => 'www.mysgr3.com'));
        $this->client->followRedirects(true);
    }
    
    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Entrar')->form(array(
            '_username' => 'jose',
            '_password' => 'amarillo',
        ));
        $this->client->submit($form);
        
        $this->assertTrue($this->client->getResponse()->isRedirect('/personal'), "El login salio mal");
    }

    public function testCreacionReunion()
    {
        //$this->doLogin();
        //$this->client->followRedirects(false);
        //Cremos el navegador
        $crawler = $this->client->request('GET', '/');
        
        echo $this->client->getResponse();
        
        $this->assertTrue($this->client->getResponse()->isRedirect('/login'), "No se pudo completar la peticion de inicio");
        //$this->assertTrue($crawler->filter('html:contains("Server Configuration")')->count() > 0);
        
    }
    
    
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/reunion/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /reunion/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'jmbermudo_sgr3bundle_reuniontype[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'jmbermudo_sgr3bundle_reuniontype[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
