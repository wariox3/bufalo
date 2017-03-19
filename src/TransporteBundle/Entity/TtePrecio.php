<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_precio")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TtePrecioRepository")
 */
class TtePrecio
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_precio_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoPrecioPk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="TtePrecioDetalle", mappedBy="precioRel")
     */
    protected $preciosDetallesPrecioRel;     

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preciosDetallesPrecioRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codigoPrecioPk
     *
     * @return integer
     */
    public function getCodigoPrecioPk()
    {
        return $this->codigoPrecioPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TtePrecio
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
     * Add preciosDetallesPrecioRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesPrecioRel
     *
     * @return TtePrecio
     */
    public function addPreciosDetallesPrecioRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesPrecioRel)
    {
        $this->preciosDetallesPrecioRel[] = $preciosDetallesPrecioRel;

        return $this;
    }

    /**
     * Remove preciosDetallesPrecioRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesPrecioRel
     */
    public function removePreciosDetallesPrecioRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesPrecioRel)
    {
        $this->preciosDetallesPrecioRel->removeElement($preciosDetallesPrecioRel);
    }

    /**
     * Get preciosDetallesPrecioRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosDetallesPrecioRel()
    {
        return $this->preciosDetallesPrecioRel;
    }
}
