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
     * @ORM\Column(name="peso_facturar", type="float")
     */
    private $pesoFacturar = 0;    
    
    /**
     * @ORM\Column(name="declarado", type="float")
     */
    private $declarado = 0;     

    /**
     * @ORM\Column(name="flete", type="float")
     */
    private $flete = 0; 

    /**
     * @ORM\Column(name="manejo", type="float")
     */
    private $manejo = 0; 
    
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
     * @ORM\Column(name="observacion", type="string", length=1000, nullable=true)
     */    
    private $observacion;    
    
    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadDestinoFk;    

    /**
     * @ORM\Column(name="codigo_empaque_fk", type="integer", nullable=true)
     */    
    private $codigoEmpaqueFk; 

    /**
     * @ORM\Column(name="codigo_empaque_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpaqueEmpresaFk;    
    
    /**     
     * @ORM\Column(name="estado_despacho_proveedor", type="boolean")
     */    
    private $estadoDespachoProveedor = false;      
    
    /**
     * @ORM\Column(name="codigo_despacho_proveedor_fk", type="integer", nullable=true)
     */    
    private $codigoDespachoProveedorFk;    
    
    /**     
     * @ORM\Column(name="devolver_documento", type="boolean")
     */    
    private $devolverDocumento = false;     
    
    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="guiasEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;     
    
    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="guiasCiudadDestinoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_destino_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadDestinoRel;          
    
    /**
     * @ORM\ManyToOne(targetEntity="TteEmpaqueEmpresa", inversedBy="guiasEmpaqueEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empaque_empresa_fk", referencedColumnName="codigo_empaque_empresa_pk")
     */
    protected $empaqueEmpresaRel;    
    
    /**
     * @ORM\ManyToOne(targetEntity="TteDespacho", inversedBy="guiasDespachoProveedorRel")
     * @ORM\JoinColumn(name="codigo_despacho_proveedor_fk", referencedColumnName="codigo_despacho_pk")
     */
    protected $despachoProveedorRel;         


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
     * Set consecutivo
     *
     * @param float $consecutivo
     *
     * @return TteGuia
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return TteGuia
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
     * Set pesoFacturar
     *
     * @param float $pesoFacturar
     *
     * @return TteGuia
     */
    public function setPesoFacturar($pesoFacturar)
    {
        $this->pesoFacturar = $pesoFacturar;

        return $this;
    }

    /**
     * Get pesoFacturar
     *
     * @return float
     */
    public function getPesoFacturar()
    {
        return $this->pesoFacturar;
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
     * Set flete
     *
     * @param float $flete
     *
     * @return TteGuia
     */
    public function setFlete($flete)
    {
        $this->flete = $flete;

        return $this;
    }

    /**
     * Get flete
     *
     * @return float
     */
    public function getFlete()
    {
        return $this->flete;
    }

    /**
     * Set manejo
     *
     * @param float $manejo
     *
     * @return TteGuia
     */
    public function setManejo($manejo)
    {
        $this->manejo = $manejo;

        return $this;
    }

    /**
     * Get manejo
     *
     * @return float
     */
    public function getManejo()
    {
        return $this->manejo;
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return TteGuia
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
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
     * Set codigoEmpaqueEmpresaFk
     *
     * @param integer $codigoEmpaqueEmpresaFk
     *
     * @return TteGuia
     */
    public function setCodigoEmpaqueEmpresaFk($codigoEmpaqueEmpresaFk)
    {
        $this->codigoEmpaqueEmpresaFk = $codigoEmpaqueEmpresaFk;

        return $this;
    }

    /**
     * Get codigoEmpaqueEmpresaFk
     *
     * @return integer
     */
    public function getCodigoEmpaqueEmpresaFk()
    {
        return $this->codigoEmpaqueEmpresaFk;
    }

    /**
     * Set estadoDespachoProveedor
     *
     * @param boolean $estadoDespachoProveedor
     *
     * @return TteGuia
     */
    public function setEstadoDespachoProveedor($estadoDespachoProveedor)
    {
        $this->estadoDespachoProveedor = $estadoDespachoProveedor;

        return $this;
    }

    /**
     * Get estadoDespachoProveedor
     *
     * @return boolean
     */
    public function getEstadoDespachoProveedor()
    {
        return $this->estadoDespachoProveedor;
    }

    /**
     * Set codigoDespachoProveedorFk
     *
     * @param integer $codigoDespachoProveedorFk
     *
     * @return TteGuia
     */
    public function setCodigoDespachoProveedorFk($codigoDespachoProveedorFk)
    {
        $this->codigoDespachoProveedorFk = $codigoDespachoProveedorFk;

        return $this;
    }

    /**
     * Get codigoDespachoProveedorFk
     *
     * @return integer
     */
    public function getCodigoDespachoProveedorFk()
    {
        return $this->codigoDespachoProveedorFk;
    }

    /**
     * Set devolverDocumento
     *
     * @param boolean $devolverDocumento
     *
     * @return TteGuia
     */
    public function setDevolverDocumento($devolverDocumento)
    {
        $this->devolverDocumento = $devolverDocumento;

        return $this;
    }

    /**
     * Get devolverDocumento
     *
     * @return boolean
     */
    public function getDevolverDocumento()
    {
        return $this->devolverDocumento;
    }

    /**
     * Set empresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpresa $empresaRel
     *
     * @return TteGuia
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
     * Set empaqueEmpresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpaqueEmpresa $empaqueEmpresaRel
     *
     * @return TteGuia
     */
    public function setEmpaqueEmpresaRel(\TransporteBundle\Entity\TteEmpaqueEmpresa $empaqueEmpresaRel = null)
    {
        $this->empaqueEmpresaRel = $empaqueEmpresaRel;

        return $this;
    }

    /**
     * Get empaqueEmpresaRel
     *
     * @return \TransporteBundle\Entity\TteEmpaqueEmpresa
     */
    public function getEmpaqueEmpresaRel()
    {
        return $this->empaqueEmpresaRel;
    }

    /**
     * Set despachoProveedorRel
     *
     * @param \TransporteBundle\Entity\TteDespacho $despachoProveedorRel
     *
     * @return TteGuia
     */
    public function setDespachoProveedorRel(\TransporteBundle\Entity\TteDespacho $despachoProveedorRel = null)
    {
        $this->despachoProveedorRel = $despachoProveedorRel;

        return $this;
    }

    /**
     * Get despachoProveedorRel
     *
     * @return \TransporteBundle\Entity\TteDespacho
     */
    public function getDespachoProveedorRel()
    {
        return $this->despachoProveedorRel;
    }
}
