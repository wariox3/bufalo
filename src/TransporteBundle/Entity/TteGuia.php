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
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadDestinoFk;    
    

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
}
