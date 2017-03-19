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
     * @ORM\Column(name="porcentaje_manejo", type="float")
     */
    private $porcentajeManejo = 0;    
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->usersEmpresaRel = new \Doctrine\Common\Collections\ArrayCollection();
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
}
