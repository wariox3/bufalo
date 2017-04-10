<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_empaque")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteEmpaqueRepository")
 */
class TteEmpaque
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empaque_pk", type="integer")
     */        
    private $codigoEmpaquePk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;           
    
    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="empaqueRel")
     */
    protected $guiasEmpaqueRel;       

    /**
     * @ORM\OneToMany(targetEntity="TtePrecioDetalle", mappedBy="empaqueRel")
     */
    protected $preciosDetallesEmpaqueRel;     
    
    /**
     * @ORM\OneToMany(targetEntity="TteEmpaqueEmpresa", mappedBy="empaqueRel")
     */
    protected $empaquesEmpresasEmpaqueRel; 


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guiasEmpaqueRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preciosDetallesEmpaqueRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empaquesEmpresasEmpaqueRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoEmpaquePk
     *
     * @param integer $codigoEmpaquePk
     *
     * @return TteEmpaque
     */
    public function setCodigoEmpaquePk($codigoEmpaquePk)
    {
        $this->codigoEmpaquePk = $codigoEmpaquePk;

        return $this;
    }

    /**
     * Get codigoEmpaquePk
     *
     * @return integer
     */
    public function getCodigoEmpaquePk()
    {
        return $this->codigoEmpaquePk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TteEmpaque
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
     * Add guiasEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpaqueRel
     *
     * @return TteEmpaque
     */
    public function addGuiasEmpaqueRel(\TransporteBundle\Entity\TteGuia $guiasEmpaqueRel)
    {
        $this->guiasEmpaqueRel[] = $guiasEmpaqueRel;

        return $this;
    }

    /**
     * Remove guiasEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpaqueRel
     */
    public function removeGuiasEmpaqueRel(\TransporteBundle\Entity\TteGuia $guiasEmpaqueRel)
    {
        $this->guiasEmpaqueRel->removeElement($guiasEmpaqueRel);
    }

    /**
     * Get guiasEmpaqueRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasEmpaqueRel()
    {
        return $this->guiasEmpaqueRel;
    }

    /**
     * Add preciosDetallesEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpaqueRel
     *
     * @return TteEmpaque
     */
    public function addPreciosDetallesEmpaqueRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpaqueRel)
    {
        $this->preciosDetallesEmpaqueRel[] = $preciosDetallesEmpaqueRel;

        return $this;
    }

    /**
     * Remove preciosDetallesEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpaqueRel
     */
    public function removePreciosDetallesEmpaqueRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesEmpaqueRel)
    {
        $this->preciosDetallesEmpaqueRel->removeElement($preciosDetallesEmpaqueRel);
    }

    /**
     * Get preciosDetallesEmpaqueRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosDetallesEmpaqueRel()
    {
        return $this->preciosDetallesEmpaqueRel;
    }

    /**
     * Add empaquesEmpresasEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpaqueRel
     *
     * @return TteEmpaque
     */
    public function addEmpaquesEmpresasEmpaqueRel(\TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpaqueRel)
    {
        $this->empaquesEmpresasEmpaqueRel[] = $empaquesEmpresasEmpaqueRel;

        return $this;
    }

    /**
     * Remove empaquesEmpresasEmpaqueRel
     *
     * @param \TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpaqueRel
     */
    public function removeEmpaquesEmpresasEmpaqueRel(\TransporteBundle\Entity\TteEmpaqueEmpresa $empaquesEmpresasEmpaqueRel)
    {
        $this->empaquesEmpresasEmpaqueRel->removeElement($empaquesEmpresasEmpaqueRel);
    }

    /**
     * Get empaquesEmpresasEmpaqueRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpaquesEmpresasEmpaqueRel()
    {
        return $this->empaquesEmpresasEmpaqueRel;
    }
}
