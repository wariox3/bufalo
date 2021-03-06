<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_ciudad")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteCiudadRepository")
 */
class TteCiudad
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoCiudadPk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\Column(name="codigo_dane_departamento", type="string", length=10, nullable=true)
     */    
    private $codigoDaneDepartamento;    

    /**
     * @ORM\Column(name="codigo_dane_municipio", type="string", length=10, nullable=true)
     */    
    private $codigoDaneMunicipio;    

    /**
     * @ORM\Column(name="codigo_dane", type="string", length=10, nullable=true)
     */    
    private $codigoDane;

    /**
     * @ORM\Column(name="codigo_dane_numerico", type="float", nullable=true)
     */    
    private $codigoDaneNumerico = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="ciudadDestinoRel")
     */
    protected $guiasCiudadDestinoRel;       

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="ciudadOrigenRel")
     */
    protected $guiasCiudadOrigenRel;    
    
    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="ciudadRel")
     */
    protected $destinatariosCiudadRel; 

    /**
     * @ORM\OneToMany(targetEntity="TtePrecioDetalle", mappedBy="ciudadRel")
     */
    protected $preciosDetallesCiudadRel; 
    
    /**
     * @ORM\OneToMany(targetEntity="TtePrecioDetalle", mappedBy="ciudadOrigenRel")
     */
    protected $preciosDetallesCiudadOrigenRel;     
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guiasCiudadDestinoRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codigoCiudadPk
     *
     * @return integer
     */
    public function getCodigoCiudadPk()
    {
        return $this->codigoCiudadPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TteCiudad
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
     * Set codigoDaneDepartamento
     *
     * @param string $codigoDaneDepartamento
     *
     * @return TteCiudad
     */
    public function setCodigoDaneDepartamento($codigoDaneDepartamento)
    {
        $this->codigoDaneDepartamento = $codigoDaneDepartamento;

        return $this;
    }

    /**
     * Get codigoDaneDepartamento
     *
     * @return string
     */
    public function getCodigoDaneDepartamento()
    {
        return $this->codigoDaneDepartamento;
    }

    /**
     * Set codigoDaneMunicipio
     *
     * @param string $codigoDaneMunicipio
     *
     * @return TteCiudad
     */
    public function setCodigoDaneMunicipio($codigoDaneMunicipio)
    {
        $this->codigoDaneMunicipio = $codigoDaneMunicipio;

        return $this;
    }

    /**
     * Get codigoDaneMunicipio
     *
     * @return string
     */
    public function getCodigoDaneMunicipio()
    {
        return $this->codigoDaneMunicipio;
    }

    /**
     * Set codigoDane
     *
     * @param string $codigoDane
     *
     * @return TteCiudad
     */
    public function setCodigoDane($codigoDane)
    {
        $this->codigoDane = $codigoDane;

        return $this;
    }

    /**
     * Get codigoDane
     *
     * @return string
     */
    public function getCodigoDane()
    {
        return $this->codigoDane;
    }

    /**
     * Add guiasCiudadDestinoRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasCiudadDestinoRel
     *
     * @return TteCiudad
     */
    public function addGuiasCiudadDestinoRel(\TransporteBundle\Entity\TteGuia $guiasCiudadDestinoRel)
    {
        $this->guiasCiudadDestinoRel[] = $guiasCiudadDestinoRel;

        return $this;
    }

    /**
     * Remove guiasCiudadDestinoRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasCiudadDestinoRel
     */
    public function removeGuiasCiudadDestinoRel(\TransporteBundle\Entity\TteGuia $guiasCiudadDestinoRel)
    {
        $this->guiasCiudadDestinoRel->removeElement($guiasCiudadDestinoRel);
    }

    /**
     * Get guiasCiudadDestinoRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasCiudadDestinoRel()
    {
        return $this->guiasCiudadDestinoRel;
    }

    /**
     * Add destinatariosCiudadRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosCiudadRel
     *
     * @return TteCiudad
     */
    public function addDestinatariosCiudadRel(\TransporteBundle\Entity\TteDestinatario $destinatariosCiudadRel)
    {
        $this->destinatariosCiudadRel[] = $destinatariosCiudadRel;

        return $this;
    }

    /**
     * Remove destinatariosCiudadRel
     *
     * @param \TransporteBundle\Entity\TteDestinatario $destinatariosCiudadRel
     */
    public function removeDestinatariosCiudadRel(\TransporteBundle\Entity\TteDestinatario $destinatariosCiudadRel)
    {
        $this->destinatariosCiudadRel->removeElement($destinatariosCiudadRel);
    }

    /**
     * Get destinatariosCiudadRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinatariosCiudadRel()
    {
        return $this->destinatariosCiudadRel;
    }

    /**
     * Add preciosDetallesCiudadRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadRel
     *
     * @return TteCiudad
     */
    public function addPreciosDetallesCiudadRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadRel)
    {
        $this->preciosDetallesCiudadRel[] = $preciosDetallesCiudadRel;

        return $this;
    }

    /**
     * Remove preciosDetallesCiudadRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadRel
     */
    public function removePreciosDetallesCiudadRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadRel)
    {
        $this->preciosDetallesCiudadRel->removeElement($preciosDetallesCiudadRel);
    }

    /**
     * Get preciosDetallesCiudadRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosDetallesCiudadRel()
    {
        return $this->preciosDetallesCiudadRel;
    }

    /**
     * Add preciosDetallesCiudadOrigenRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadOrigenRel
     *
     * @return TteCiudad
     */
    public function addPreciosDetallesCiudadOrigenRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadOrigenRel)
    {
        $this->preciosDetallesCiudadOrigenRel[] = $preciosDetallesCiudadOrigenRel;

        return $this;
    }

    /**
     * Remove preciosDetallesCiudadOrigenRel
     *
     * @param \TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadOrigenRel
     */
    public function removePreciosDetallesCiudadOrigenRel(\TransporteBundle\Entity\TtePrecioDetalle $preciosDetallesCiudadOrigenRel)
    {
        $this->preciosDetallesCiudadOrigenRel->removeElement($preciosDetallesCiudadOrigenRel);
    }

    /**
     * Get preciosDetallesCiudadOrigenRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosDetallesCiudadOrigenRel()
    {
        return $this->preciosDetallesCiudadOrigenRel;
    }

    /**
     * Set codigoDaneNumerico
     *
     * @param float $codigoDaneNumerico
     *
     * @return TteCiudad
     */
    public function setCodigoDaneNumerico($codigoDaneNumerico)
    {
        $this->codigoDaneNumerico = $codigoDaneNumerico;

        return $this;
    }

    /**
     * Get codigoDaneNumerico
     *
     * @return float
     */
    public function getCodigoDaneNumerico()
    {
        return $this->codigoDaneNumerico;
    }

    /**
     * Add guiasCiudadOrigenRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasCiudadOrigenRel
     *
     * @return TteCiudad
     */
    public function addGuiasCiudadOrigenRel(\TransporteBundle\Entity\TteGuia $guiasCiudadOrigenRel)
    {
        $this->guiasCiudadOrigenRel[] = $guiasCiudadOrigenRel;

        return $this;
    }

    /**
     * Remove guiasCiudadOrigenRel
     *
     * @param \TransporteBundle\Entity\TteGuia $guiasCiudadOrigenRel
     */
    public function removeGuiasCiudadOrigenRel(\TransporteBundle\Entity\TteGuia $guiasCiudadOrigenRel)
    {
        $this->guiasCiudadOrigenRel->removeElement($guiasCiudadOrigenRel);
    }

    /**
     * Get guiasCiudadOrigenRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuiasCiudadOrigenRel()
    {
        return $this->guiasCiudadOrigenRel;
    }
}
