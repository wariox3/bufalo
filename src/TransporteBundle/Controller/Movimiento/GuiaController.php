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
            $arEmprea = $this->getUser()->getEmpresaRel();
            $arGuia->setEmpresaRel($arEmprea);
            $arGuia->setFecha(new \DateTime('now'));
        }        
        $form = $this->createForm(TteGuiaType::class, $arGuia);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {                
                $arGuia = $form->getData();
                if($arGuia->getEmpaqueEmpresaRel()) {
                    $arUsuario = $this->getUser();
                    $arCiudadOrigen = new \TransporteBundle\Entity\TteCiudad();
                    $arCiudadOrigen = $em->getRepository('TransporteBundle:TteCiudad')->find($arUsuario->getCodigoCiudadFk());                    
                    $arGuia->setCiudadOrigenRel($arCiudadOrigen);
                    $arGuia->setEmpaqueRel($arGuia->getEmpaqueEmpresaRel()->getEmpaqueRel());                    
                    $manejo = $arGuia->getEmpresaRel()->getPorcentajeManejo() * $arGuia->getDeclarado() / 100;                
                    $pesoFacturar = 0;
                    if($arGuia->getPeso() >= $arGuia->getPesoVolumen()) {
                        $pesoFacturar = $arGuia->getPeso();
                    } else {
                        $pesoFacturar = $arGuia->getPesoVolumen();
                    }
                    $flete = 0;
                    if($pesoFacturar > 0) {
                        $arPrecioDetalle = $em->getRepository('TransporteBundle:TtePrecioDetalle')->findOneBy(array('codigoEmpresaFk' => $arGuia->getEmpresaRel()->getCodigoEmpresaPk(), 'codigoCiudadOrigenFk' => $arCiudadOrigen->getCodigoCiudadPk(), 'codigoCiudadFk' => $arGuia->getCiudadDestinoRel()->getCodigoCiudadPk(), 'codigoEmpaqueFk' => $arGuia->getEmpaqueEmpresaRel()->getCodigoEmpaqueFk()));
                        if($arPrecioDetalle) {
                            $flete = $arPrecioDetalle->getVrKilo() * $pesoFacturar;
                        }
                    }
                    $arGuia->setManejo(round($manejo));
                    $arGuia->setFlete(round($flete));
                    if($codigoGuia == 0) {
                        $consecutivo = $em->getRepository('TransporteBundle:TteGuia')->consecutivo($arGuia->getEmpresaRel()->getCodigoEmpresaPk());
                        $arGuia->setConsecutivo($consecutivo);
                    }
                    $em->persist($arGuia);
                    $em->flush();
                    if ($form->get('guardarnuevo')->isClicked()) {
                        return $this->redirect($this->generateUrl('tte_movimiento_guia_nuevo', array('codigoGuia' => 0)));
                    } else {
                        return $this->redirect($this->generateUrl('tte_movimiento_guia'));
                        //return $this->redirect($this->generateUrl('brs_tur_movimiento_pedido_detalle', array('codigoPedido' => $arPedido->getCodigoPedidoPk())));
                    }                     
                } else {
                    echo "Debe seleccionar un empaque";
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
