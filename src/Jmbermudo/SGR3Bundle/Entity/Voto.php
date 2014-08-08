<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jmbermudo\SGR3Bundle\Entity\VotoRepository")
 */
class Voto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="acepta", type="boolean")
     */
    private $acepta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valido", type="boolean")
     */
    private $valido;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="PreReserva", inversedBy="votaciones")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $prereserva;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="votaciones")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $usuario;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Voto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set acepta
     *
     * @param boolean $acepta
     * @return Voto
     */
    public function setAcepta($acepta)
    {
        $this->acepta = $acepta;

        return $this;
    }

    /**
     * Get acepta
     *
     * @return boolean 
     */
    public function getAcepta()
    {
        return $this->acepta;
    }

    /**
     * Set valido
     *
     * @param boolean $valido
     * @return Voto
     */
    public function setValido($valido)
    {
        $this->valido = $valido;

        return $this;
    }

    /**
     * Get valido
     *
     * @return boolean 
     */
    public function getValido()
    {
        return $this->valido;
    }

    /**
     * Set prereserva
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $prereserva
     * @return Voto
     */
    public function setPrereserva(\Jmbermudo\SGR3Bundle\Entity\PreReserva $prereserva = null)
    {
        $this->prereserva = $prereserva;

        return $this;
    }

    /**
     * Get prereserva
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\PreReserva 
     */
    public function getPrereserva()
    {
        return $this->prereserva;
    }

    
    /**
     * Set usuario
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Usuario $usuario
     * @return Voto
     */
    public function setUsuario(\Jmbermudo\SGR3Bundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
