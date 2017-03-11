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
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * Constructor
     */
    public function __construct()
    {
        $this->guiasEmpaqueRel = new \Doctrine\Common\Collections\ArrayCollection();
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
}
