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
}