<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_precio_detalle")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TtePrecioDetalleRepository")
 */
class TtePrecioDetalle
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_precio_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoPrecioDetallePk;           

    /**
     * @ORM\Column(name="codigo_precio_fk", type="integer", nullable=true)
     */    
    private $codigoPrecioFk;    

    /**
     * @ORM\ManyToOne(targetEntity="TtePrecio", inversedBy="preciosDetallesPrecioRel")
     * @ORM\JoinColumn(name="codigo_precio_fk", referencedColumnName="codigo_precio_pk")
     */
    protected $precioRel;     


    /**
     * Get codigoPrecioDetallePk
     *
     * @return integer
     */
    public function getCodigoPrecioDetallePk()
    {
        return $this->codigoPrecioDetallePk;
    }

    /**
     * Set codigoPrecioFk
     *
     * @param integer $codigoPrecioFk
     *
     * @return TtePrecioDetalle
     */
    public function setCodigoPrecioFk($codigoPrecioFk)
    {
        $this->codigoPrecioFk = $codigoPrecioFk;

        return $this;
    }

    /**
     * Get codigoPrecioFk
     *
     * @return integer
     */
    public function getCodigoPrecioFk()
    {
        return $this->codigoPrecioFk;
    }

    /**
     * Set precioRel
     *
     * @param \TransporteBundle\Entity\TtePrecio $precioRel
     *
     * @return TtePrecioDetalle
     */
    public function setPrecioRel(\TransporteBundle\Entity\TtePrecio $precioRel = null)
    {
        $this->precioRel = $precioRel;

        return $this;
    }

    /**
     * Get precioRel
     *
     * @return \TransporteBundle\Entity\TtePrecio
     */
    public function getPrecioRel()
    {
        return $this->precioRel;
    }
}
