<?php

namespace Jmbermudo\SGR3Bundle\Entity;

use Doctrine\ORM\EntityRepository;
use Jmbermudo\SGR3Bundle\Entity\Voto;

/**
 * VotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VotoRepository extends EntityRepository
{
    /**
     * Devuelve los votos que un usuario ha realizado para una reunión en concreto,
     * o un array de votos en blanco, uno por cada prereserva
     * @param Usuario $usuario
     * @param Reunion $reunion
     * @return \Jmbermudo\SGR3Bundle\Entity\Voto
     */
    public function getVotosUsuario($usuario, $reunion)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT v
            FROM JmbermudoSGR3Bundle:Voto v
            JOIN v.prereserva p
            WHERE v.usuario = :usuario
            AND p.reunion = :reunion
            AND v.valido = true'
        )
        ->setParameter('usuario', $usuario->getId())
        ->setParameter('reunion', $reunion->getId());
        
        $reuniones = $query->getResult();
        
//        //Si está vacía devolvemos un voto en blanco por cada prereserva
//        if(empty($reuniones)){
//            foreach($reunion->getPrereservas() as $prereserva){
//                $v = new Voto();
//                $v->setPrereserva($prereserva);
//                $v->setUsuario($usuario);
//                $reuniones[] = $v;
//            }            
//        }
//        
        return $reuniones;
    }
    
    public function anulaVotoUsuarioReunion($usuario, $reunion)
    {
        $res = true; 
        
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'UPDATE JmbermudoSGR3Bundle:Voto v
            SET v.valido = 0
            WHERE v.usuario = :usuario
            AND v.prereserva in (
                SELECT p
                FROM JmbermudoSGR3Bundle:Prereserva p
                WHERE p.reunion = :reunion
            )'
        )
        ->setParameter('usuario', $usuario->getId())
        ->setParameter('reunion', $reunion->getId());
        
        try {
            $return = $query->execute();
        }
        catch (\Exception $ex) {
            //La sentencia ha fallado
            $res = false;
        }
        
        return $res;
    }
}
