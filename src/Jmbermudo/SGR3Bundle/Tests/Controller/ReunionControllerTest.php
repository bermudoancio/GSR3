<?php

namespace Jmbermudo\SGR3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Jmbermudo\SGR3Bundle\Entity\PreReserva;
use Jmbermudo\SGR3Bundle\Controller\ReunionController;

class ReunionControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array(), array('DOCUMENT_ROOT' => '/', 'HTTP_HOST' => 'www.mysgr3.com'));
        //$this->client->followRedirects(true);
    }
    
    public function testCreateAction()
    {
        $this->doLogin();
        
        //Introducimos un componente aleatorio para comprobar que la prueba es 100% efectiva
        $randComponent = rand(0, 1000);
        
        $crawler = $this->client->request('GET', '/reuniones/13/edit');
        
        $form = $crawler->selectButton('Editar')->form(array(
            'jmbermudo_sgr3bundle_reunion[nombrePublico]' => "Test nombre público $randComponent",
            'jmbermudo_sgr3bundle_reunion[nombrePrivado]' => "Test nombre privado $randComponent",
            'jmbermudo_sgr3bundle_reunion[descripcion]' => 'Test. Descripción'
        ));
        
        //No podemos interactuar con las pre-reservas
                
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        //$response = $this->client->getResponse();
        
        $this->assertGreaterThan(0, $crawler->filter('[value="Test nombre público ' . $randComponent . '"]')->count(), 'La reunión no se ha podido editar');
        
    }
    
    /**
     * Prueba del solapamiento de pre-reservas.
     * Crearemos varias condiciones de prueba:
     *      1. 2 pre-reservas que no se solapan. Debe devolver false
     *      2. 2 pre-reservas con las mismas horas de inicio y fin. Debe devolver true
     *      3. Una pre-reserva empieza antes y termina después que la otra. Debe devolver true
     *      4. Una pre-reserva empieza antes y termina durante la otra. Debe devolver true
     */
    public function testTestSolapa()
    {
        $controlador = new ReunionController();
        
        $pre1 = new PreReserva();
        $pre2 = new PreReserva();
        
        //La fecha será igual para todas
        $fecha = '2014-10-10 ';
        
        //Caso 1
        $horaInicio1 = new \DateTime($fecha . '01:00:00');
        $horaFin1 = new \DateTime($fecha . '03:00:00');
        $horaInicio2 = new \DateTime($fecha . '03:00:00');
        $horaFin2 = new \DateTime($fecha . '04:00:00');
        
        $pre1->setHoraInicio($horaInicio1);
        $pre1->setHoraFin($horaFin1);
        $pre2->setHoraInicio($horaInicio2);
        $pre2->setHoraFin($horaFin2);
        
        $res = $controlador->testSolapa($pre1, $pre2);
        
        $this->assertFalse($res, 'Las pre-reservas solapan cuando no deberían solapar. Caso 1');
        
        //Caso 2
        $horaInicio1 = new \DateTime($fecha . '01:00:00');
        $horaFin1 = new \DateTime($fecha . '03:00:00');
        $horaInicio2 = new \DateTime($fecha . '01:00:00');
        $horaFin2 = new \DateTime($fecha . '03:00:00');
        
        $pre1->setHoraInicio($horaInicio1);
        $pre1->setHoraFin($horaFin1);
        $pre2->setHoraInicio($horaInicio2);
        $pre2->setHoraFin($horaFin2);
        
        $res = $controlador->testSolapa($pre1, $pre2);
        
        $this->assertTrue($res, 'Las pre-reservas no se solapan cuando sí deberían hacerlo. Caso 2');
        
        //Caso 3
        $horaInicio1 = new \DateTime($fecha . '01:00:00');
        $horaFin1 = new \DateTime($fecha . '03:00:00');
        $horaInicio2 = new \DateTime($fecha . '02:00:00');
        $horaFin2 = new \DateTime($fecha . '02:40:00');
        
        $pre1->setHoraInicio($horaInicio1);
        $pre1->setHoraFin($horaFin1);
        $pre2->setHoraInicio($horaInicio2);
        $pre2->setHoraFin($horaFin2);
        
        $res = $controlador->testSolapa($pre1, $pre2);
        
        $this->assertTrue($res, 'Las pre-reservas no se solapan cuando sí deberían hacerlo. Caso 3');
        
        //Caso 4
        $horaInicio1 = new \DateTime($fecha . '01:00:00');
        $horaFin1 = new \DateTime($fecha . '03:00:00');
        $horaInicio2 = new \DateTime($fecha . '02:00:00');
        $horaFin2 = new \DateTime($fecha . '04:00:00');
        
        $pre1->setHoraInicio($horaInicio1);
        $pre1->setHoraFin($horaFin1);
        $pre2->setHoraInicio($horaInicio2);
        $pre2->setHoraFin($horaFin2);
        
        $res = $controlador->testSolapa($pre1, $pre2);
        
        $this->assertTrue($res, 'Las pre-reservas no se solapan cuando sí deberían hacerlo. Caso 4');
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
