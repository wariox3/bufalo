<?php

namespace TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CuentasCobrarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TteGuiaRepository extends EntityRepository
{
    public function listaDql($codigoEmpresa = "", $fechaDesde = "", $fechaHasta = "") {
        $dql   = "SELECT g FROM TransporteBundle:TteGuia g WHERE g.codigoEmpresaFk = $codigoEmpresa " ;            
        if($fechaDesde != "") {
            $dql .= " AND g.fecha >= '" . $fechaDesde . "'";
        }
        if($fechaHasta != "") {
            $dql .= " AND g.fecha <= '" . $fechaHasta . "'";
        }        
        $dql .= " ORDER BY g.codigoGuiaPk DESC";
        return $dql;
    }     
    
    public function guiaPendienteDespachoDql($codigoEmpresa = "") {
        $dql   = "SELECT g FROM TransporteBundle:TteGuia g WHERE g.codigoEmpresaFk = $codigoEmpresa AND g.estadoDespachoProveedor = 0 " ;            
        $dql .= " ORDER BY g.codigoGuiaPk DESC";
        return $dql;
    }      
    
    public function guiasDespachoDql($codigoDespacho = "") {
        $dql   = "SELECT g FROM TransporteBundle:TteGuia g WHERE g.codigoDespachoProveedorFk = $codigoDespacho " ;            
        $dql .= " ORDER BY g.codigoGuiaPk DESC";
        return $dql;
    }      

    public function consecutivo($codigoEmpresa) {
        $em = $this->getEntityManager();        
        $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();        
        $arEmpresa = $em->getRepository('TransporteBundle:TteEmpresa')->find($codigoEmpresa);  
        $consecutivo = $arEmpresa->getConsecutivoGuia();
        $arEmpresa->setConsecutivoGuia($consecutivo + 1);
        $em->persist($arEmpresa);
        $em->flush();
        return $consecutivo;
    }        
}