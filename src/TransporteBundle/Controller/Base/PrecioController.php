<?php

namespace TransporteBundle\Controller\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteDestinatarioType;

class PrecioController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/base/precio/", name="tte_base_precio")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $this->lista();                     
        $arPreciosDetalles = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Base/PrecioDetalle:lista.html.twig', array(
            'arPreciosDetalles' => $arPreciosDetalles
            ));
    }     
    
    private function lista() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TtePrecioDetalle')->listaDQL($this->getUser()->getCodigoEmpresaFk());
    }    

    
}
