<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_guia")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteGuiaRepository")
 */
class TteGuia
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_guia_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoGuiaPk;        

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;     
    
    /**
     * @ORM\Column(name="identificacion", type="string", length=30, nullable=true)
     */    
    private $identificacion;    

    /**
     * @ORM\Column(name="destinatario", type="string", length=150, nullable=true)
     */    
    private $destinatario;    
    
    /**
     * @ORM\Column(name="nombre1", type="string", length=60, nullable=true)
     */    
    private $nombre1;

    /**
     * @ORM\Column(name="nombre2", type="string", length=60, nullable=true)
     */    
    private $nombre2;
    
    /**
     * @ORM\Column(name="apellido1", type="string", length=60, nullable=true)
     */    
    private $apellido1;    
    
    /**
     * @ORM\Column(name="apellido2", type="string", length=60, nullable=true)
     */    
    private $apellido2;    
    
    /**
     * @ORM\Column(name="direccion", type="string", length=100, nullable=true)
     */    
    private $direccion;    

    /**
     * @ORM\Column(name="barrio", type="string", length=80, nullable=true)
     */    
    private $barrio; 
    
    /**
     * @ORM\Column(name="telefono", type="string", length=40, nullable=true)
     */    
    private $telefono;    

    /**
     * @ORM\Column(name="correo", type="string", length=80, nullable=true)
     */    
    private $correo;

    /**
     * @ORM\Column(name="documento", type="string", length=60, nullable=true)
     */    
    private $documento;    
    
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
     * @ORM\Column(name="largo", type="integer")
     */    
    private $largo = 0;    
    
    /**
     * @ORM\Column(name="alto", type="integer")
     */    
    private $alto = 0;    
    
    /**
     * @ORM\Column(name="ancho", type="integer")
     */    
    private $ancho = 0;    
    
    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadDestinoFk;    

    /**
     * @ORM\Column(name="codigo_empaque_fk", type="integer", nullable=true)
     */    
    private $codigoEmpaqueFk; 
    
    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="guiasCiudadDestinoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_destino_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadDestinoRel;     

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpaque", inversedBy="guiasEmpaqueRel")
     * @ORM\JoinColumn(name="codigo_empaque_fk", referencedColumnName="codigo_empaque_pk")
     */
    protected $empaqueRel;      
    
    /**
     * Get codigoGuiaPk
     *
     * @return integer
     */
    public function getCodigoGuiaPk()
    {
        return $this->codigoGuiaPk;
    }

    /**
     * Set codigoEmpresaFk
     *
     * @param integer $codigoEmpresaFk
     *
     * @return TteGuia
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
     * Set identificacion
     *
     * @param string $identificacion
     *
     * @return TteGuia
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return string
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set destinatario
     *
     * @param string $destinatario
     *
     * @return TteGuia
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return string
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Set nombre1
     *
     * @param string $nombre1
     *
     * @return TteGuia
     */
    public function setNombre1($nombre1)
    {
        $this->nombre1 = $nombre1;

        return $this;
    }

    /**
     * Get nombre1
     *
     * @return string
     */
    public function getNombre1()
    {
        return $this->nombre1;
    }

    /**
     * Set nombre2
     *
     * @param string $nombre2
     *
     * @return TteGuia
     */
    public function setNombre2($nombre2)
    {
        $this->nombre2 = $nombre2;

        return $this;
    }

    /**
     * Get nombre2
     *
     * @return string
     */
    public function getNombre2()
    {
        return $this->nombre2;
    }

    /**
     * Set apellido1
     *
     * @param string $apellido1
     *
     * @return TteGuia
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    /**
     * Get apellido1
     *
     * @return string
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * Set apellido2
     *
     * @param string $apellido2
     *
     * @return TteGuia
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get apellido2
     *
     * @return string
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return TteGuia
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
     * Set barrio
     *
     * @param string $barrio
     *
     * @return TteGuia
     */
    public function setBarrio($barrio)
    {
        $this->barrio = $barrio;

        return $this;
    }

    /**
     * Get barrio
     *
     * @return string
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return TteGuia
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
     * Set correo
     *
     * @param string $correo
     *
     * @return TteGuia
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set codigoCiudadDestinoFk
     *
     * @param integer $codigoCiudadDestinoFk
     *
     * @return TteGuia
     */
    public function setCodigoCiudadDestinoFk($codigoCiudadDestinoFk)
    {
        $this->codigoCiudadDestinoFk = $codigoCiudadDestinoFk;

        return $this;
    }

    /**
     * Get codigoCiudadDestinoFk
     *
     * @return integer
     */
    public function getCodigoCiudadDestinoFk()
    {
        return $this->codigoCiudadDestinoFk;
    }

    /**
     * Set ciudadDestinoRel
     *
     * @param \TransporteBundle\Entity\TteCiudad $ciudadDestinoRel
     *
     * @return TteGuia
     */
    public function setCiudadDestinoRel(\TransporteBundle\Entity\TteCiudad $ciudadDestinoRel = null)
    {
        $this->ciudadDestinoRel = $ciudadDestinoRel;

        return $this;
    }

    /**
     * Get ciudadDestinoRel
     *
     * @return \TransporteBundle\Entity\TteCiudad
     */
    public function getCiudadDestinoRel()
    {
        return $this->ciudadDestinoRel;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return TteGuia
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return TteGuia
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
     * @return TteGuia
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
     * @return TteGuia
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
     * @return TteGuia
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

    /**
     * Set largo
     *
     * @param integer $largo
     *
     * @return TteGuia
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return integer
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set alto
     *
     * @param integer $alto
     *
     * @return TteGuia
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return integer
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set ancho
     *
     * @param integer $ancho
     *
     * @return TteGuia
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return integer
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set codigoEmpaqueFk
     *
     * @param integer $codigoEmpaqueFk
     *
     * @return TteGuia
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
     * @return TteGuia
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
}
