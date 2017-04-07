<?php

namespace TransporteBundle\Controller\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteDestinatarioType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DestinatarioController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/base/destinatario/", name="tte_base_destinatario")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $form = $this->formularioLista();
        $form->handleRequest($request);        
        $this->lista();  
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($form->get('BtnEliminar')->isClicked()) {
                    $arrSeleccionados = $request->request->get('ChkSeleccionar');
                    if(count($arrSeleccionados) > 0) {
                        foreach ($arrSeleccionados AS $codigo) {                            
                            $arDestinatarioEliminar = $em->getRepository('TransporteBundle:TteDestinatario')->find($codigo);                                
                            $em->remove($arDestinatarioEliminar);                                                            
                        }
                        $em->flush();
                    }                    
                }
            }   
        }
        $arDestinatarios = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Base/Destinatario:lista.html.twig', array(
            'arDestinatarios' => $arDestinatarios,
            'form' => $form->createView()
            ));
    }
    
    /**
     * @Route("/tte/base/destinatario/nuevo/{codigoDestinatario}", name="tte_base_destinatario_nuevo")
     */
    public function nuevoAction(Request $request, $codigoDestinatario = 0) {
        $em = $this->getDoctrine()->getManager();        
        $arDestinatario = new \TransporteBundle\Entity\TteDestinatario();
        if ($codigoDestinatario != 0) {
            $arDestinatario = $em->getRepository('TransporteBundle:TteDestinatario')->find($codigoDestinatario);            
        } else {
            $arUsuario = $this->getUser();            
            $arDestinatario->setEmpresaRel($arUsuario->getEmpresaRel());
        }        
        $form = $this->createForm(TteDestinatarioType::class, $arDestinatario);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $arDestinatario = $form->getData();
                $em->persist($arDestinatario);
                $em->flush();
                if ($form->get('guardarnuevo')->isClicked()) {
                    return $this->redirect($this->generateUrl('tte_base_destinatario_nuevo', array('codigoDestinatario' => 0)));
                } else {
                    return $this->redirect($this->generateUrl('tte_base_destinatario'));
                    //return $this->redirect($this->generateUrl('brs_tur_movimiento_pedido_detalle', array('codigoPedido' => $arPedido->getCodigoPedidoPk())));
                }                
            }
        }
        return $this->render('TransporteBundle:Base/Destinatario:nuevo.html.twig', array(
                    'form' => $form->createView()));
    }    
    
    private function lista() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteDestinatario')->listaDQL($this->getUser()->getCodigoEmpresaFk());
    }    

    private function formularioLista() {
        $em = $this->getDoctrine()->getManager();
        $session = new session;        
        $form = $this->createFormBuilder()
                ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
                ->getForm();
        return $form;
    }    
    
}
