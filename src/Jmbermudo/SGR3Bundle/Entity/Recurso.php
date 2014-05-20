<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurso
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jmbermudo\SGR3Bundle\Entity\RecursoRepository")
 */
class Recurso
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="id_escuela", type="string", length=255)
     */
    private $idEscuela;

    /**
     * @var string
     *
     * @ORM\Column(name="localizacion", type="text")
     */
    private $localizacion;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="responsable_de_recursos")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $responsable;
    
    /**
     * @ORM\OneToMany(targetEntity="PreReserva", mappedBy="recurso", cascade={"all"})
     */
    private $prereservas;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * Set nombre
     *
     * @param string $nombre
     * @return Recurso
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set idEscuela
     *
     * @param string $idEscuela
     * @return Recurso
     */
    public function setIdEscuela($idEscuela)
    {
        $this->idEscuela = $idEscuela;

        return $this;
    }

    /**
     * Get idEscuela
     *
     * @return string 
     */
    public function getIdEscuela()
    {
        return $this->idEscuela;
    }

    /**
     * Set localizacion
     *
     * @param string $localizacion
     * @return Recurso
     */
    public function setLocalizacion($localizacion)
    {
        $this->localizacion = $localizacion;

        return $this;
    }

    /**
     * Get localizacion
     *
     * @return string 
     */
    public function getLocalizacion()
    {
        return $this->localizacion;
    }

    /**
     * Set responsable
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Usuario $responsable
     * @return Recurso
     */
    public function setResponsable(\Jmbermudo\SGR3Bundle\Entity\Usuario $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\Usuario 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prereservas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add prereservas
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $prereservas
     * @return Recurso
     */
    public function addPrereserva(\Jmbermudo\SGR3Bundle\Entity\PreReserva $prereservas)
    {
        $this->prereservas[] = $prereservas;

        return $this;
    }

    /**
     * Remove prereservas
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $prereservas
     */
    public function removePrereserva(\Jmbermudo\SGR3Bundle\Entity\PreReserva $prereservas)
    {
        $this->prereservas->removeElement($prereservas);
    }

    /**
     * Get prereservas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrereservas()
    {
        return $this->prereservas;
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Recurso
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
