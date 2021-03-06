<?php

namespace TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CuentasCobrarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TteDestinatarioRepository extends EntityRepository
{
    public function listaDql($codigoEmpresa = "", $codigoDestinatario = "", $nombreDestinatario ="") {
        $dql   = "SELECT d FROM TransporteBundle:TteDestinatario d WHERE d.codigoEmpresaFk = $codigoEmpresa " ;            
        if($nombreDestinatario != "") {
            $dql .= " AND d.nombreCorto LIKE '%" . $nombreDestinatario . "%'";
        }
        $dql .= " ORDER BY d.codigoDestinatarioPk DESC";
        return $dql;
    }     
}