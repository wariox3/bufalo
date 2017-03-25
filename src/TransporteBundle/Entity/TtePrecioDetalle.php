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
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadFk;    
    
    /**
     * @ORM\Column(name="codigo_empaque_fk", type="integer", nullable=true)
     */    
    private $codigoEmpaqueFk;    
    
    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;    
    
    /**
     * @ORM\Column(name="vr_kilo", type="float")
     */
    private $vrKilo = 0;    
    
    /**
     * @ORM\Column(name="vr_unidad", type="float")
     */
    private $vrUnidad = 0;    
    
    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="preciosDetallesEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;             

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="preciosDetallesCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;    

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpaque", inversedBy="preciosDetallesEmpaqueRel")
     * @ORM\JoinColumn(name="codigo_empaque_fk", referencedColumnName="codigo_empaque_pk")
     */
    protected $empaqueRel;     
    
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

    /**
     * Set codigoCiudadFk
     *
     * @param integer $codigoCiudadFk
     *
     * @return TtePrecioDetalle
     */
    public function setCodigoCiudadFk($codigoCiudadFk)
    {
        $this->codigoCiudadFk = $codigoCiudadFk;

        return $this;
    }

    /**
     * Get codigoCiudadFk
     *
     * @return integer
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * Set ciudadRel
     *
     * @param \TransporteBundle\Entity\TteCiudad $ciudadRel
     *
     * @return TtePrecioDetalle
     */
    public function setCiudadRel(\TransporteBundle\Entity\TteCiudad $ciudadRel = null)
    {
        $this->ciudadRel = $ciudadRel;

        return $this;
    }

    /**
     * Get ciudadRel
     *
     * @return \TransporteBundle\Entity\TteCiudad
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * Set codigoEmpaqueFk
     *
     * @param integer $codigoEmpaqueFk
     *
     * @return TtePrecioDetalle
     */
    public function setCodigoEmpaqueFk($codigoEmpaqueFk)
    {
        $this->codigoEmpaqueFk = $codigoEmpaqueFk;

        return $this;
    }

    /**
     * Get codigoEmpaqueFk
     *
     * @return integer
     */
    public function getCodigoEmpaqueFk()
    {
        return $this->codigoEmpaqueFk;
    }

    /**
     * Set empaqueRel
     *
     * @param \TransporteBundle\Entity\TteEmpaque $empaqueRel
     *
     * @return TtePrecioDetalle
     */
    public function setEmpaqueRel(\TransporteBundle\Entity\TteEmpaque $empaqueRel = null)
    {
        $this->empaqueRel = $empaqueRel;

        return $this;
    }

    /**
     * Get empaqueRel
     *
     * @return \TransporteBundle\Entity\TteEmpaque
     */
    public function getEmpaqueRel()
    {
        return $this->empaqueRel;
    }

    /**
     * Set vrKilo
     *
     * @param float $vrKilo
     *
     * @return TtePrecioDetalle
     */
    public function setVrKilo($vrKilo)
    {
        $this->vrKilo = $vrKilo;

        return $this;
    }

    /**
     * Get vrKilo
     *
     * @return float
     */
    public function getVrKilo()
    {
        return $this->vrKilo;
    }

    /**
     * Set vrUnidad
     *
     * @param float $vrUnidad
     *
     * @return TtePrecioDetalle
     */
    public function setVrUnidad($vrUnidad)
    {
        $this->vrUnidad = $vrUnidad;

        return $this;
    }

    /**
     * Get vrUnidad
     *
     * @return float
     */
    public function getVrUnidad()
    {
        return $this->vrUnidad;
    }

    /**
     * Set codigoEmpresaFk
     *
     * @param integer $codigoEmpresaFk
     *
     * @return TtePrecioDetalle
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk)
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;

        return $this;
    }

    /**
     * Get codigoEmpresaFk
     *
     * @return integer
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * Set empresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpresa $empresaRel
     *
     * @return TtePrecioDetalle
     */
    public function setEmpresaRel(\TransporteBundle\Entity\TteEmpresa $empresaRel = null)
    {
        $this->empresaRel = $empresaRel;

        return $this;
    }

    /**
     * Get empresaRel
     *
     * @return \TransporteBundle\Entity\TteEmpresa
     */
    public function getEmpresaRel()
    {
        return $this->empresaRel;
    }
}
