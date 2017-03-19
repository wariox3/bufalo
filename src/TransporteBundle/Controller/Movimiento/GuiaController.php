<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteGuiaType;

class GuiaController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/movimiento/guia/", name="tte_movimiento_guia")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $this->lista();                     
        $arGuias = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Movimiento/Guia:lista.html.twig', array(
            'arGuias' => $arGuias
            ));
    }
    
    /**
     * @Route("/tte/movimiento/guia/nuevo/{codigoGuia}", name="tte_movimiento_guia_nuevo")
     */
    public function nuevoAction(Request $request, $codigoGuia = 0) {
        $em = $this->getDoctrine()->getManager();        
        $arGuia = new \TransporteBundle\Entity\TteGuia();
        if ($codigoGuia != 0) {
            $arGuia = $em->getRepository('TransporteBundle:TteGuia')->find($codigoGuia);            
        } else {            
            $arGuia->setFecha(new \DateTime('now'));
        }        
        $form = $this->createForm(TteGuiaType::class, $arGuia);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $arEmprea = $this->getUser()->getEmpresaRel();
                $arGuia = $form->getData();
                $manejo = $arEmprea->getPorcentajeManejo() * $arGuia->getDeclarado() / 100;                
                $arGuia->setManejo($manejo);
                if($codigoGuia == 0) {                    
                    $arGuia->setEmpresaRel($arEmprea);
                }
                $em->persist($arGuia);
                $em->flush();
                if ($form->get('guardarnuevo')->isClicked()) {
                    return $this->redirect($this->generateUrl('tte_movimiento_guia_nuevo', array('codigoGuia' => 0)));
                } else {
                    return $this->redirect($this->generateUrl('tte_movimiento_guia'));
                    //return $this->redirect($this->generateUrl('brs_tur_movimiento_pedido_detalle', array('codigoPedido' => $arPedido->getCodigoPedidoPk())));
                }                
            }
        }
        return $this->render('TransporteBundle:Movimiento/Guia:nuevo.html.twig', array(
                    'form' => $form->createView()));
    }    
    
    private function lista() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteGuia')->listaDQL($this->getUser()->getCodigoEmpresaFk());
    }    

    
}
