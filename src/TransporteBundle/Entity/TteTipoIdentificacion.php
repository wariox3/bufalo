<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_tipo_identificacion")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteTipoIdentificacionRepository")
 */
class TteTipoIdentificacion
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_tipo_identificacion_pk", type="string", length=2)
     */        
    private $codigoTipoIdentificacionPk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;               

    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="tipoIdentificacionRel")
     */
    protected $destinatariosTipoIdentificacionRel;     
    
    /**
     * Set codigoTipoIdentificacionPk
     *
     * @param string $codigoTipoIdentificacionPk
     *
     * @return TteTipoIdentificacion
     */
    public function setCodigoTipoIdentificacionPk($codigoTipoIdentificacionPk)
    {
        $this->codigoTipoIdentificacionPk = $codigoTipoIdentificacionPk;

        return $this;
    }

    /**
     * Get codigoTipoIdentificacionPk
     *
     * @return string
     */
    public function getCodigoTipoIdentificacionPk()
    {
        return $this->codigoTipoIdentificacionPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TteTipoIdentificacion
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
        $this->destinatariosTipoIdentificacionRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add destinatariosTipoIdentificacionRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosTipoIdentificacionRel
     *
     * @return TteTipoIdentificacion
     */
    public function addDestinatariosTipoIdentificacionRel(\TransporteBundle\Entity\TteDestinatario $destinatariosTipoIdentificacionRel)
    {
        $this->destinatariosTipoIdentificacionRel[] = $destinatariosTipoIdentificacionRel;

        return $this;
    }

    /**
     * Remove destinatariosTipoIdentificacionRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosTipoIdentificacionRel
     */
    public function removeDestinatariosTipoIdentificacionRel(\TransporteBundle\Entity\TteDestinatario $destinatariosTipoIdentificacionRel)
    {
        $this->destinatariosTipoIdentificacionRel->removeElement($destinatariosTipoIdentificacionRel);
    }

    /**
     * Get destinatariosTipoIdentificacionRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinatariosTipoIdentificacionRel()
    {
        return $this->destinatariosTipoIdentificacionRel;
    }
}
