<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_despacho")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteDespachoRepository")
 */
class TteDespacho
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_despacho_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoDespachoPk;        

    /**
     * @ORM\Column(name="consecutivo", type="float")
     */
    private $consecutivo = 0;    
    
    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;     
    
    /**
     * @ORM\Column(name="fecha", type="date")
     */    
    private $fecha;         

    /**
     * @ORM\Column(name="cantidad", type="integer")
     */    
    private $cantidad = 0;    
    
    /**
     * @ORM\Column(name="peso", type="float")
     */
    private $peso = 0;
    
    /**
     * @ORM\Column(name="peso_volumen", type="float")
     */
    private $pesoVolumen = 0;      
    
    /**
     * @ORM\Column(name="declarado", type="float")
     */
    private $declarado = 0;    
    
    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="despachosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;     

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="despachoProveedorRel")
     */
    protected $guiasDespachoProveedorRel;     

    /**
     * Get codigoDespachoPk
     *
     * @return integer
     */
    public function getCodigoDespachoPk()
    {
        return $this->codigoDespachoPk;
    }

    /**
     * Set consecutivo
     *
     * @param float $consecutivo
     *
     * @return TteDespacho
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return float
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set codigoEmpresaFk
     *
     * @param integer $codigoEmpresaFk
     *
     * @return TteDespacho
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return TteDespacho
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
     * Set empresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpresa $empresaRel
     *
     * @return TteDespacho
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guiasDespachoProveedorRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add guiasDespachoProveedorRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasDespachoProveedorRel
     *
     * @return TteDespacho
     */
    public function addGuiasDespachoProveedorRel(\TransporteBundle\Entity\TteGuia $guiasDespachoProveedorRel)
    {
        $this->guiasDespachoProveedorRel[] = $guiasDespachoProveedorRel;

        return $this;
    }

    /**
     * Remove guiasDespachoProveedorRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasDespachoProveedorRel
     */
    public function removeGuiasDespachoProveedorRel(\TransporteBundle\Entity\TteGuia $guiasDespachoProveedorRel)
    {
        $this->guiasDespachoProveedorRel->removeElement($guiasDespachoProveedorRel);
    }

    /**
     * Get guiasDespachoProveedorRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasDespachoProveedorRel()
    {
        return $this->guiasDespachoProveedorRel;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return TteDespacho
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set peso
     *
     * @param float $peso
     *
     * @return TteDespacho
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set pesoVolumen
     *
     * @param float $pesoVolumen
     *
     * @return TteDespacho
     */
    public function setPesoVolumen($pesoVolumen)
    {
        $this->pesoVolumen = $pesoVolumen;

        return $this;
    }

    /**
     * Get pesoVolumen
     *
     * @return float
     */
    public function getPesoVolumen()
    {
        return $this->pesoVolumen;
    }

    /**
     * Set declarado
     *
     * @param float $declarado
     *
     * @return TteDespacho
     */
    public function setDeclarado($declarado)
    {
        $this->declarado = $declarado;

        return $this;
    }

    /**
     * Get declarado
     *
     * @return float
     */
    public function getDeclarado()
    {
        return $this->declarado;
    }
}
