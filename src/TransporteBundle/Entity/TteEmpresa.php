<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_empresa")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteEmpresaRepository")
 */
class TteEmpresa
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoEmpresaPk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\Column(name="nit", type="string", length=15, nullable=true)
     */    
    private $nit;    
    
    /**
     * @ORM\Column(name="direccion", type="string", length=120, nullable=true)
     */    
    private $direccion;    
    
    /**
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */    
    private $telefono;    

    /**
     * @ORM\Column(name="consecutivo_guia", type="integer")
     */
    private $consecutivoGuia = 0;    
    
    /**
     * @ORM\Column(name="consecutivo_guia_desde", type="integer")
     */
    private $consecutivoGuiaDesde = 0;

    /**
     * @ORM\Column(name="consecutivo_guia_hasta", type="integer")
     */
    private $consecutivoGuiaHasta = 0;
    
    /**
     * @ORM\Column(name="porcentaje_manejo", type="float")
     */
    private $porcentajeManejo = 0;    
    
    /**
     * @ORM\Column(name="manejo_minimo_despacho", type="float")
     */
    private $manejoMinimoDespacho = 0;     
    
    /**
     * @ORM\Column(name="cuenta_kit", type="string", length=15, nullable=true)
     */    
    private $cuentaKit;    
    
    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="empresaRel")
     */
    protected $guiasEmpresaRel;     
    
    /**
     * @ORM\OneToMany(targetEntity="TteDespacho", mappedBy="empresaRel")
     */
    protected $despachosEmpresaRel;    
    
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="empresaRel")
     */
    protected $usersEmpresaRel;     
    
    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="empresaRel")
     */
    protected $destinatariosEmpresaRel;    
    
    /**
     * @ORM\OneToMany(targetEntity="TteEmpaqueEmpresa", mappedBy="empresaRel")
     */
    protected $empaquesEmpresasEmpresaRel;     

    /**
     * @ORM\OneToMany(targetEntity="TtePrecioDetalle", mappedBy="empresaRel")
     */
    protected $preciosDetallesEmpresaRel;    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guiasEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->despachosEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usersEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->destinatariosEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codigoEmpresaPk
     *
     * @return integer
     */
    public function getCodigoEmpresaPk()
    {
        return $this->codigoEmpresaPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TteEmpresa
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
     * Set porcentajeManejo
     *
     * @param float $porcentajeManejo
     *
     * @return TteEmpresa
     */
    public function setPorcentajeManejo($porcentajeManejo)
    {
        $this->porcentajeManejo = $porcentajeManejo;

        return $this;
    }

    /**
     * Get porcentajeManejo
     *
     * @return float
     */
    public function getPorcentajeManejo()
    {
        return $this->porcentajeManejo;
    }

    /**
     * Add guiasEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addGuiasEmpresaRel(\TransporteBundle\Entity\TteGuia $guiasEmpresaRel)
    {
        $this->guiasEmpresaRel[] = $guiasEmpresaRel;

        return $this;
    }

    /**
     * Remove guiasEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpresaRel
     */
    public function removeGuiasEmpresaRel(\TransporteBundle\Entity\TteGuia $guiasEmpresaRel)
    {
        $this->guiasEmpresaRel->removeElement($guiasEmpresaRel);
    }

    /**
     * Get guiasEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasEmpresaRel()
    {
        return $this->guiasEmpresaRel;
    }

    /**
     * Add despachosEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteDespacho $despachosEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addDespachosEmpresaRel(\TransporteBundle\Entity\TteDespacho $despachosEmpresaRel)
    {
        $this->despachosEmpresaRel[] = $despachosEmpresaRel;

        return $this;
    }

    /**
     * Remove despachosEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteDespacho $despachosEmpresaRel
     */
    public function removeDespachosEmpresaRel(\TransporteBundle\Entity\TteDespacho $despachosEmpresaRel)
    {
        $this->despachosEmpresaRel->removeElement($despachosEmpresaRel);
    }

    /**
     * Get despachosEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDespachosEmpresaRel()
    {
        return $this->despachosEmpresaRel;
    }

    /**
     * Add usersEmpresaRel
     *
     * @param \TransporteBundle\Entity\User $usersEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addUsersEmpresaRel(\TransporteBundle\Entity\User $usersEmpresaRel)
    {
        $this->usersEmpresaRel[] = $usersEmpresaRel;

        return $this;
    }

    /**
     * Remove usersEmpresaRel
     *
     * @param \TransporteBundle\Entity\User $usersEmpresaRel
     */
    public function removeUsersEmpresaRel(\TransporteBundle\Entity\User $usersEmpresaRel)
    {
        $this->usersEmpresaRel->removeElement($usersEmpresaRel);
    }

    /**
     * Get usersEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersEmpresaRel()
    {
        return $this->usersEmpresaRel;
    }

    /**
     * Add destinatariosEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addDestinatariosEmpresaRel(\TransporteBundle\Entity\TteDestinatario $destinatariosEmpresaRel)
    {
        $this->destinatariosEmpresaRel[] = $destinatariosEmpresaRel;

        return $this;
    }

    /**
     * Remove destinatariosEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosEmpresaRel
     */
    public function removeDestinatariosEmpresaRel(\TransporteBundle\Entity\TteDestinatario $destinatariosEmpresaRel)
    {
        $this->destinatariosEmpresaRel->removeElement($destinatariosEmpresaRel);
    }

    /**
     * Get destinatariosEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinatariosEmpresaRel()
    {
        return $this->destinatariosEmpresaRel;
    }

    /**
     * Add empaquesEmpresasEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addEmpaquesEmpresasEmpresaRel(\TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpresaRel)
    {
        $this->empaquesEmpresasEmpresaRel[] = $empaquesEmpresasEmpresaRel;

        return $this;
    }

    /**
     * Remove empaquesEmpresasEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpresaRel
     */
    public function removeEmpaquesEmpresasEmpresaRel(\TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpresaRel)
    {
        $this->empaquesEmpresasEmpresaRel->removeElement($empaquesEmpresasEmpresaRel);
    }

    /**
     * Get empaquesEmpresasEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpaquesEmpresasEmpresaRel()
    {
        return $this->empaquesEmpresasEmpresaRel;
    }

    /**
     * Add preciosDetallesEmpresaRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpresaRel
     *
     * @return TteEmpresa
     */
    public function addPreciosDetallesEmpresaRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpresaRel)
    {
        $this->preciosDetallesEmpresaRel[] = $preciosDetallesEmpresaRel;

        return $this;
    }

    /**
     * Remove preciosDetallesEmpresaRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpresaRel
     */
    public function removePreciosDetallesEmpresaRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpresaRel)
    {
        $this->preciosDetallesEmpresaRel->removeElement($preciosDetallesEmpresaRel);
    }

    /**
     * Get preciosDetallesEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosDetallesEmpresaRel()
    {
        return $this->preciosDetallesEmpresaRel;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return TteEmpresa
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return TteEmpresa
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return TteEmpresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set consecutivoGuia
     *
     * @param integer $consecutivoGuia
     *
     * @return TteEmpresa
     */
    public function setConsecutivoGuia($consecutivoGuia)
    {
        $this->consecutivoGuia = $consecutivoGuia;

        return $this;
    }

    /**
     * Get consecutivoGuia
     *
     * @return integer
     */
    public function getConsecutivoGuia()
    {
        return $this->consecutivoGuia;
    }

    /**
     * Set consecutivoGuiaDesde
     *
     * @param integer $consecutivoGuiaDesde
     *
     * @return TteEmpresa
     */
    public function setConsecutivoGuiaDesde($consecutivoGuiaDesde)
    {
        $this->consecutivoGuiaDesde = $consecutivoGuiaDesde;

        return $this;
    }

    /**
     * Get consecutivoGuiaDesde
     *
     * @return integer
     */
    public function getConsecutivoGuiaDesde()
    {
        return $this->consecutivoGuiaDesde;
    }

    /**
     * Set consecutivoGuiaHasta
     *
     * @param integer $consecutivoGuiaHasta
     *
     * @return TteEmpresa
     */
    public function setConsecutivoGuiaHasta($consecutivoGuiaHasta)
    {
        $this->consecutivoGuiaHasta = $consecutivoGuiaHasta;

        return $this;
    }

    /**
     * Get consecutivoGuiaHasta
     *
     * @return integer
     */
    public function getConsecutivoGuiaHasta()
    {
        return $this->consecutivoGuiaHasta;
    }

    /**
     * Set cuentaKit
     *
     * @param string $cuentaKit
     *
     * @return TteEmpresa
     */
    public function setCuentaKit($cuentaKit)
    {
        $this->cuentaKit = $cuentaKit;

        return $this;
    }

    /**
     * Get cuentaKit
     *
     * @return string
     */
    public function getCuentaKit()
    {
        return $this->cuentaKit;
    }

    /**
     * Set manejoMinimoDespacho
     *
     * @param float $manejoMinimoDespacho
     *
     * @return TteEmpresa
     */
    public function setManejoMinimoDespacho($manejoMinimoDespacho)
    {
        $this->manejoMinimoDespacho = $manejoMinimoDespacho;

        return $this;
    }

    /**
     * Get manejoMinimoDespacho
     *
     * @return float
     */
    public function getManejoMinimoDespacho()
    {
        return $this->manejoMinimoDespacho;
    }
}
