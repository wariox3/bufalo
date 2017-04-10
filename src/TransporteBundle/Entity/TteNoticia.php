<?php

namespace TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tte_noticia")
 * @ORM\Entity(repositoryClass="TransporteBundle\Repository\TteNoticiaRepository")
 */
class TteNoticia
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_noticia_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoNoticiaPk;           
    
    /**
     * @ORM\Column(name="titulo", type="string", length=500, nullable=true)
     */    
    private $titulo;

    /**
     * @ORM\Column(name="noticia", type="text", nullable=true)
     */    
    private $noticia;   
    

    /**
     * Get codigoNoticiaPk
     *
     * @return integer
     */
    public function getCodigoNoticiaPk()
    {
        return $this->codigoNoticiaPk;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return TteNoticia
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set noticia
     *
     * @param string $noticia
     *
     * @return TteNoticia
     */
    public function setNoticia($noticia)
    {
        $this->noticia = $noticia;

        return $this;
    }

    /**
     * Get noticia
     *
     * @return string
     */
    public function getNoticia()
    {
        return $this->noticia;
    }
}
