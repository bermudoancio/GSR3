<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Usuario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jmbermudo\SGR3Bundle\Entity\UsuarioRepository")
 */
class Usuario extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;
    
    /**
     * @ORM\OneToMany(targetEntity="Recurso", mappedBy="responsable", cascade={"persist"})
     */
    private $responsable_de_recursos;


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
     * @return Usuario
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->responsable_de_recursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add responsable_de_recursos
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Recurso $responsableDeRecursos
     * @return Usuario
     */
    public function addResponsableDeRecurso(\Jmbermudo\SGR3Bundle\Entity\Recurso $responsableDeRecursos)
    {
        $this->responsable_de_recursos[] = $responsableDeRecursos;

        return $this;
    }

    /**
     * Remove responsable_de_recursos
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Recurso $responsableDeRecursos
     */
    public function removeResponsableDeRecurso(\Jmbermudo\SGR3Bundle\Entity\Recurso $responsableDeRecursos)
    {
        $this->responsable_de_recursos->removeElement($responsableDeRecursos);
    }

    /**
     * Get responsable_de_recursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsableDeRecursos()
    {
        return $this->responsable_de_recursos;
    }
}
