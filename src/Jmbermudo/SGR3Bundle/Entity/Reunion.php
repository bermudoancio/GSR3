<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reunion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jmbermudo\SGR3Bundle\Entity\ReunionRepository")
 */
class Reunion
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
     * @ORM\Column(name="nombrePublico", type="string", length=255)
     */
    private $nombrePublico;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrePrivado", type="string", length=255)
     */
    private $nombrePrivado;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime")
     */
    private $fechaCreacion;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="anulada", type="boolean")
     */
    private $anulada;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="creador_de_reuniones")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $creador;
    
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="reuniones")
     * @ORM\JoinTable(name="invitados_reunion")
     **/
    private $invitados;
    
    /**
     * @ORM\OneToMany(targetEntity="PreReserva", mappedBy="reunion", cascade={"all"})
     **/
    private $prereservas;


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
     * Set nombrePublico
     *
     * @param string $nombrePublico
     * @return Reunion
     */
    public function setNombrePublico($nombrePublico)
    {
        $this->nombrePublico = $nombrePublico;

        return $this;
    }

    /**
     * Get nombrePublico
     *
     * @return string 
     */
    public function getNombrePublico()
    {
        return $this->nombrePublico;
    }

    /**
     * Set nombrePrivado
     *
     * @param string $nombrePrivado
     * @return Reunion
     */
    public function setNombrePrivado($nombrePrivado)
    {
        $this->nombrePrivado = $nombrePrivado;

        return $this;
    }

    /**
     * Get nombrePrivado
     *
     * @return string 
     */
    public function getNombrePrivado()
    {
        return $this->nombrePrivado;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Reunion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Reunion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invitados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->prereservas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creador
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Usuario $creador
     * @return Reunion
     */
    public function setCreador(\Jmbermudo\SGR3Bundle\Entity\Usuario $creador = null)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\Usuario 
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Add invitados
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Usuario $invitados
     * @return Reunion
     */
    public function addInvitado(\Jmbermudo\SGR3Bundle\Entity\Usuario $invitados)
    {
        $this->invitados[] = $invitados;

        return $this;
    }

    /**
     * Remove invitados
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Usuario $invitados
     */
    public function removeInvitado(\Jmbermudo\SGR3Bundle\Entity\Usuario $invitados)
    {
        $this->invitados->removeElement($invitados);
    }

    /**
     * Get invitados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvitados()
    {
        return $this->invitados;
    }

    /**
     * Anula la reunión, y todas las pre-reservas efectuadas
     *
     * @param boolean $anulada
     * @return Reunion
     */
    public function setAnulada($anulada)
    {
        $this->anulada = $anulada;
        
        if($this->anulada){
            $prereservas = $this->getPrereservas();
            
            foreach ($prereservas as $prereserva){
                $prereserva->setAnulada($this->anulada);
            }
        }

        return $this;
    }

    /**
     * Get anulada
     *
     * @return boolean 
     */
    public function getAnulada()
    {
        return $this->anulada;
    }
    
    /**
     * Esta función devolverá la pre-reserva aceptada (en caso de que la hubiera)
     * o NULL en caso contrario. Aún habrá que comprobar que la pre-reserva es
     * reservable, es decir, si el responsable (si lo hubiera), ha aceptado
     */
    public function getReservaAceptada()
    {
        $aceptada = null;
        
        if(!$this->getAnulada()){
            foreach($this->prereservas as $prereserva){
                if($prereserva->getAceptada()){
                    $aceptada = $prereserva;
                    break;
                }
            }
        }
        
        return $aceptada;
    }

    /**
     * Add prereservas
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $prereservas
     * @return Reunion
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
}
