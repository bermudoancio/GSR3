<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;
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
     * @ORM\OneToMany(targetEntity="Reunion", mappedBy="creador", cascade={"persist"})
     */
    private $creador_de_reuniones;
    
    /**
     * @ORM\ManyToMany(targetEntity="Reunion", mappedBy="invitados")
     **/
    private $reuniones;


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

    /**
     * Add creador_de_reuniones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Reunion $creadorDeReuniones
     * @return Usuario
     */
    public function addCreadorDeReunione(\Jmbermudo\SGR3Bundle\Entity\Reunion $creadorDeReuniones)
    {
        $this->creador_de_reuniones[] = $creadorDeReuniones;

        return $this;
    }

    /**
     * Remove creador_de_reuniones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Reunion $creadorDeReuniones
     */
    public function removeCreadorDeReunione(\Jmbermudo\SGR3Bundle\Entity\Reunion $creadorDeReuniones)
    {
        $this->creador_de_reuniones->removeElement($creadorDeReuniones);
    }

    /**
     * Get creador_de_reuniones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreadorDeReuniones()
    {
        return $this->creador_de_reuniones;
    }

    /**
     * Add reuniones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Reunion $reuniones
     * @return Usuario
     */
    public function addReunione(\Jmbermudo\SGR3Bundle\Entity\Reunion $reuniones)
    {
        $this->reuniones[] = $reuniones;

        return $this;
    }

    /**
     * Remove reuniones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Reunion $reuniones
     */
    public function removeReunione(\Jmbermudo\SGR3Bundle\Entity\Reunion $reuniones)
    {
        $this->reuniones->removeElement($reuniones);
    }

    /**
     * Get reuniones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReuniones()
    {
        return $this->reuniones;
    }
    
    /**
     * //@TODO: Esta función devuelve un array con las reuniones que el usuario tiene
     * pendientes, es decir, cuya fecha seleccionada de reunión no ha pasado; o
     * aquellas que todavía están en periodo de votación
     * @return array
     */
    public function getReunionesPendientes()
    {
        $reuniones = $this->getReuniones();

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("anulada", "0"))
            ->andWhere(Criteria::expr()->eq("fechaCreacion", "0"))
        ;

        $reunionesPendientes = $reuniones->matching($criteria);
        
        return $reunionesPendientes;
    }
    
    public function __toString()
    {
        return $this->getNombre() . ' ' . $this->getApellidos();
    }
}
