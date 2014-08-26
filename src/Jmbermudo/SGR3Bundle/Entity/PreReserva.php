<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreReserva
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jmbermudo\SGR3Bundle\Entity\PreReservaRepository")
 */
class PreReserva
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
     * @var \Date
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_inicio", type="time")
     */
    private $horaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_fin", type="time")
     */
    private $horaFin;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="prereservas")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $recurso;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="responsable_responde", type="boolean")
     */
    private $responsableResponde;

    /**
     * @var boolean
     *
     * @ORM\Column(name="responsable_acepta", type="boolean")
     */
    private $responsableAcepta;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="anulada", type="boolean")
     */
    private $anulada;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Reunion", inversedBy="prereservas")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $reunion;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="aceptada", type="boolean")
     */
    private $aceptada;
    
    /**
     * @ORM\OneToMany(targetEntity="Voto", mappedBy="prereserva", cascade={"all"})
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
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     * @return PreReserva
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime 
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     * @return PreReserva
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime 
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * Set responsableAcepta
     *
     * @param boolean $responsableAcepta
     * @return PreReserva
     */
    public function setResponsableAcepta($responsableAcepta)
    {
        $this->responsableAcepta = $responsableAcepta;

        return $this;
    }

    /**
     * Get responsableAcepta
     *
     * @return boolean 
     */
    public function getResponsableAcepta()
    {
        return $this->responsableAcepta;
    }

    /**
     * Set responsableResponde
     *
     * @param boolean $responsableResponde
     * @return PreReserva
     */
    public function setResponsableResponde($responsableResponde)
    {
        $this->responsableResponde = $responsableResponde;

        return $this;
    }

    /**
     * Get responsableResponde
     *
     * @return boolean 
     */
    public function getResponsableResponde()
    {
        return $this->responsableResponde;
    }

    /**
     * Set anulada
     *
     * @param boolean $anulada
     * @return PreReserva
     */
    public function setAnulada($anulada)
    {
        $this->anulada = $anulada;

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
     * Set recurso
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Recurso $recurso
     * @return PreReserva
     */
    public function setRecurso(\Jmbermudo\SGR3Bundle\Entity\Recurso $recurso = null)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\Recurso 
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return PreReserva
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
     * Set reunion
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Reunion $reunion
     * @return PreReserva
     */
    public function setReunion(\Jmbermudo\SGR3Bundle\Entity\Reunion $reunion = null)
    {
        $this->reunion = $reunion;

        return $this;
    }

    /**
     * Get reunion
     *
     * @return \Jmbermudo\SGR3Bundle\Entity\Reunion 
     */
    public function getReunion()
    {
        return $this->reunion;
    }
    
    /**
     * Este método calculará si esta pre-reserva se puede cerrar ya como reserva
     * definitiva
     */
    public function esReservable()
    {
        $reservable = true;
        
        //Si ha expirado tampoco se podrá reservar
        $reservable &= !$this->haExpirado();
        
        //Si tiene responsable, vemos si ha aceptado
        if($this->getRecurso()->getResponsable() !== null){
            if(!$this->responsableResponde || ($this->responsableResponde && !$this->responsableAcepta)){
                $reservable = false;
            }
        }
        
        return $reservable;
    }
    
    public function haExpirado(){
        $expira = false;
        
        //Antes de nada, comprobaremos que la fecha no haya pasado ya
        $fechaAhora = new \DateTime('');
            
        $fecha = $this->getFecha();
        $fecha->setTime($this->getHoraInicio()->format("H"), $this->getHoraInicio()->format("i"), 0);

        if ($fechaAhora >= $fecha){
            $expira = true;
        }
        
        return $expira;
    }

    /**
     * Set aceptada
     *
     * @param boolean $aceptada
     * @return PreReserva
     */
    public function setAceptada($aceptada)
    {
        $this->aceptada = $aceptada;

        return $this;
    }

    /**
     * Get aceptada
     *
     * @return boolean 
     */
    public function getAceptada()
    {
        return $this->aceptada;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add votaciones
     *
     * @param \Jmbermudo\SGR3Bundle\Entity\Voto $votaciones
     * @return PreReserva
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
    
    public function getNumVotaciones()
    {
        return $this->votaciones->count();
    }
}
