<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReunionControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array(), array('DOCUMENT_ROOT' => '/', 'HTTP_HOST' => 'www.mysgr3.com'));
        //$this->client->followRedirects(true);
    }
    
    public function testCompleteScenario()
    {
        $this->doLogin();
        
        // Create a new entry in the database
        $crawler = $this->client->request('GET', '/admin/recurso/new');
//        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /recurso/");
//        $crawler = $this->client->click($crawler->selectLink('Añadir un nuevo recurso')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'jmbermudo_sgr3bundle_recurso[nombre]'  => 'Test_x311',
            'jmbermudo_sgr3bundle_recurso[idEscuela]'  => 'Test_x311',
            'jmbermudo_sgr3bundle_recurso[localizacion]'  => 'Test_x311',
            // ... creamos un recurso sin responsable
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test_x311")')->count(), 'Missing element td:contains("Test_x311")');

        // Edit the entity
        $crawler = $this->client->click($crawler->filter('td:contains("Test_x311")')->siblings()->last()->filter('a')->link());

        $form = $crawler->selectButton('Editar')->form(array(
            'jmbermudo_sgr3bundle_recurso[nombre]'  => 'Foo_x311',
            'jmbermudo_sgr3bundle_recurso[idEscuela]'  => 'Foo_x311',
            'jmbermudo_sgr3bundle_recurso[localizacion]'  => 'Foo_x311',
            // ... other fields to fill
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo_x311"]')->count(), 'Missing element [value="Foo_x311"]');

        // Delete the entity
        $this->client->submit($crawler->selectButton('Eliminar')->form());
        $crawler = $this->client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $this->client->getResponse()->getContent());
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
