<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteDespachoType;

class DespachoController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/movimiento/despacho/", name="tte_movimiento_despacho")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $this->lista();                     
        $arDespachos = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Movimiento/Despacho:lista.html.twig', array(
            'arDespachos' => $arDespachos
            ));
    }
    
    /**
     * @Route("/tte/movimiento/despacho/nuevo/{codigoDespacho}", name="tte_movimiento_despacho_nuevo")
     */
    public function nuevoAction(Request $request, $codigoDespacho = 0) {
        $em = $this->getDoctrine()->getManager();        
        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
        if ($codigoDespacho != 0) {
            $arDespacho = $em->getRepository('TransporteBundle:TteDespacho')->find($codigoDespacho);            
        } else {
            $arUsuario = $this->getUser();
            $arDespacho->setFecha(new \DateTime('now'));
            $arDespacho->setEmpresaRel($arUsuario->getEmpresaRel());
        }        
        $form = $this->createForm(TteDespachoType::class, $arDespacho);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $arDespacho = $form->getData();
                $em->persist($arDespacho);
                $em->flush();
                if ($form->get('guardarnuevo')->isClicked()) {
                    return $this->redirect($this->generateUrl('tte_movimiento_despacho_nuevo', array('codigoDespacho' => 0)));
                } else {
                    return $this->redirect($this->generateUrl('tte_movimiento_despacho'));
                    //return $this->redirect($this->generateUrl('brs_tur_movimiento_pedido_detalle', array('codigoPedido' => $arPedido->getCodigoPedidoPk())));
                }                
            }
        }
        return $this->render('TransporteBundle:Movimiento/Despacho:nuevo.html.twig', array(
                    'form' => $form->createView()));
    }    
    
    private function lista() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteDespacho')->listaDQL($this->getUser()->getCodigoEmpresaFk());
    }    

    
}
