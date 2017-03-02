<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_guia")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteGuiaRepository")
 */
class TteGuia
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_guia_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoGuiaPk;        


    /**
     * Get codigoGuiaPk
     *
     * @return integer
     */
    public function getCodigoGuiaPk()
    {
        return $this->codigoGuiaPk;
    }
}
