<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_empaque_empresa")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteEmpaqueEmpresaRepository")
 */
class TteEmpaqueEmpresa
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empaque_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoEmpaqueEmpresaPk;           
    
    /**
     * @ORM\Column(name="codigo_empaque_fk", type="integer", nullable=true)
     */    
    private $codigoEmpaqueFk; 

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="empaquesEmpresasEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;         

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpaque", inversedBy="empaquesEmpresasEmpaqueRel")
     * @ORM\JoinColumn(name="codigo_empaque_fk", referencedColumnName="codigo_empaque_pk")
     */
    protected $empaqueRel;     

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="empaqueEmpresaRel")
     */
    protected $guiasEmpaqueEmpresaRel;     
    
    /**
     * Get codigoEmpaqueEmpresaPk
     *
     * @return integer
     */
    public function getCodigoEmpaqueEmpresaPk()
    {
        return $this->codigoEmpaqueEmpresaPk;
    }

    /**
     * Set codigoEmpaqueFk
     *
     * @param integer $codigoEmpaqueFk
     *
     * @return TteEmpaqueEmpresa
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
     * Set codigoEmpresaFk
     *
     * @param integer $codigoEmpresaFk
     *
     * @return TteEmpaqueEmpresa
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
     * @return TteEmpaqueEmpresa
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
     * Set empaqueRel
     *
     * @param \TransporteBundle\Entity\TteEmpaque $empaqueRel
     *
     * @return TteEmpaqueEmpresa
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
     * Constructor
     */
    public function __construct()
    {
        $this->guiasEmpaqueEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add guiasEmpaqueEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpaqueEmpresaRel
     *
     * @return TteEmpaqueEmpresa
     */
    public function addGuiasEmpaqueEmpresaRel(\TransporteBundle\Entity\TteGuia $guiasEmpaqueEmpresaRel)
    {
        $this->guiasEmpaqueEmpresaRel[] = $guiasEmpaqueEmpresaRel;

        return $this;
    }

    /**
     * Remove guiasEmpaqueEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasEmpaqueEmpresaRel
     */
    public function removeGuiasEmpaqueEmpresaRel(\TransporteBundle\Entity\TteGuia $guiasEmpaqueEmpresaRel)
    {
        $this->guiasEmpaqueEmpresaRel->removeElement($guiasEmpaqueEmpresaRel);
    }

    /**
     * Get guiasEmpaqueEmpresaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasEmpaqueEmpresaRel()
    {
        return $this->guiasEmpaqueEmpresaRel;
    }
}
