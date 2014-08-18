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
     * @ORM\OneToMany(targetEntity="Reunion", mappedBy="creador", cascade={"all"})
     */
    private $creador_de_reuniones;
    
    /**
     * @ORM\ManyToMany(targetEntity="Reunion", mappedBy="invitados")
     **/
    private $reuniones;
    
    /**
     * @ORM\OneToMany(targetEntity="Voto", mappedBy="usuario", cascade={"all"})
     **/
    private $votaciones;


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
    public function getCreadorDeReuniones($all = false)
    {
        $creador = $this->creador_de_reuniones;
        
        $criteria = Criteria::create();
        
        if(!$all){
            $criteria->where(Criteria::expr()->eq("anulada", "0"));
        }

        return $creador->matching($criteria);
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
    
    
    public function getReunionesPendientes()
    {
        $reuniones = $this->getReuniones();
        
        $reunionesPendientes = new \Doctrine\Common\Collections\ArrayCollection();

        /*
         * No usar. Esta función no funciona porque Symfony no permite aún aplicar criterios
         * de filtrado a colecciones Many to Many
         */
//        $criteria = Criteria::create()
//            ->where(Criteria::expr()->eq("anulada", "0"))
//        ;
//
//        $reunionesPendientes = $reuniones->matching($criteria);
        
        foreach($reuniones as $reunion){
            if (!$reunion->getAnulada()){
                $reunionesPendientes->add($reunion);
            }
        }
        
        return $reunionesPendientes;
    }
    
    public function __toString()
    {
        return $this->getNombre() . ' ' . $this->getApellidos();
    }

    /**
     * Add votaciones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Voto $votaciones
     * @return Usuario
     */
    public function addVotacione(\Jmbermudo\SGR3Bundle\Entity\Voto $votaciones)
    {
        $this->votaciones[] = $votaciones;

        return $this;
    }

    /**
     * Remove votaciones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Voto $votaciones
     */
    public function removeVotacione(\Jmbermudo\SGR3Bundle\Entity\Voto $votaciones)
    {
        $this->votaciones->removeElement($votaciones);
    }

    /**
     * Get votaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotaciones()
    {
        return $this->votaciones;
    }
    
}
