<?php

// src/AppBundle/Entity/User.php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=50, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="usersEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;    
    
    
    public function __construct() {
        $this->isActive = true;
        // may not be needed, see section on salt below
         $this->salt = md5(uniqid(null, true));
    }

    public function getUsername() {
        return $this->username;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        return array($this->roles);
    }

    public function eraseCredentials() {
        
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Set codigoEmpleadoFk
     *
     * @param integer $codigoEmpleadoFk
     *
     * @return User
     */
    public function setCodigoEmpleadoFk($codigoEmpleadoFk) {
        $this->codigoEmpleadoFk = $codigoEmpleadoFk;

        return $this;
    }

    /**
     * Get codigoEmpleadoFk
     *
     * @return integer
     */
    public function getCodigoEmpleadoFk() {
        return $this->codigoEmpleadoFk;
    }

    /**
     * Set codigoEmpresaFk
     *
     * @param integer $codigoEmpresaFk
     *
     * @return User
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk) {
        $this->codigoEmpresaFk = $codigoEmpresaFk;

        return $this;
    }

    /**
     * Get codigoEmpresaFk
     *
     * @return integer
     */
    public function getCodigoEmpresaFk() {
        return $this->codigoEmpresaFk;
    }

    /**
     * Set codigoVerificacion
     *
     * @param string $codigoVerificacion
     *
     * @return User
     */
    public function setCodigoVerificacion($codigoVerificacion) {
        $this->codigoVerificacion = $codigoVerificacion;

        return $this;
    }

    /**
     * Get codigoVerificacion
     *
     * @return string
     */
    public function getCodigoVerificacion() {
        return $this->codigoVerificacion;
    }

    /**
     * Set nombre1
     *
     * @param string $nombre1
     *
     * @return User
     */
    public function setNombre1($nombre1) {
        $this->nombre1 = $nombre1;

        return $this;
    }

    /**
     * Get nombre1
     *
     * @return string
     */
    public function getNombre1() {
        return $this->nombre1;
    }

    /**
     * Set nombre2
     *
     * @param string $nombre2
     *
     * @return User
     */
    public function setNombre2($nombre2) {
        $this->nombre2 = $nombre2;

        return $this;
    }

    /**
     * Get nombre2
     *
     * @return string
     */
    public function getNombre2() {
        return $this->nombre2;
    }

    /**
     * Set nombreCorto
     *
     * @param string $nombreCorto
     *
     * @return User
     */
    public function setNombreCorto($nombreCorto) {
        $this->nombreCorto = $nombreCorto;

        return $this;
    }

    /**
     * Get nombreCorto
     *
     * @return string
     */
    public function getNombreCorto() {
        return $this->nombreCorto;
    }

    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return User
     */
    public function setRoles($roles) {
        $this->roles = $roles;

        return $this;
    }


    /**
     * Set empaqueRel
     *
     * @param \TransporteBundle\Entity\TteEmpresa $empaqueRel
     *
     * @return User
     */
    public function setEmpaqueRel(\TransporteBundle\Entity\TteEmpresa $empaqueRel = null)
    {
        $this->empaqueRel = $empaqueRel;

        return $this;
    }

    /**
     * Get empaqueRel
     *
     * @return \TransporteBundle\Entity\TteEmpresa
     */
    public function getEmpaqueRel()
    {
        return $this->empaqueRel;
    }

    /**
     * Set empresaRel
     *
     * @param \TransporteBundle\Entity\TteEmpresa $empresaRel
     *
     * @return User
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
}
