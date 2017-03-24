<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteDespachoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/tte/movimiento/despacho/detalle/{codigoDespacho}", name="tte_movimiento_despacho_detalle")
     */   
    public function detalleAction(Request $request, $codigoDespacho) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
        $arDespacho = $em->getRepository('TransporteBundle:TteDespacho')->find($codigoDespacho);
        $form = $this->formularioDetalle(); 
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($form->get('BtnImprimir')->isClicked()) {
                    $objDespacho = new \TransporteBundle\Formato\Despacho();
                    $objDespacho->Generar($em, $codigoDespacho);
                }
                if ($form->get('BtnDetalleEliminar')->isClicked()) {
                    $arrSeleccionados = $request->request->get('ChkSeleccionar');
                    if (count($arrSeleccionados) > 0) {
                        $guias = $arDespacho->getGuias();
                        $cantidad = $arDespacho->getCantidad();
                        $peso = $arDespacho->getPeso();
                        $pesoVolumen = $arDespacho->getPesoVolumen();
                        $declarado = $arDespacho->getDeclarado();
                        foreach ($arrSeleccionados AS $codigo) {
                            $arGuia = new \TransporteBundle\Entity\TteGuia;
                            $arGuia = $em->getRepository('TransporteBundle:TteGuia')->find($codigo);
                            $guias--;
                            $cantidad -= $arGuia->getCantidad();
                            $peso -= $arGuia->getPeso();
                            $pesoVolumen -= $arGuia->getPesoVolumen();
                            $declarado -= $arGuia->getDeclarado();  
                            $arGuia->setDespachoProveedorRel(null);
                            $arGuia->setEstadoDespachoProveedor(0);
                            $em->persist($arGuia);
                        }
                        $arDespacho->setGuias($guias);
                        $arDespacho->setCantidad($cantidad);
                        $arDespacho->setPeso($peso);
                        $arDespacho->setPesoVolumen($pesoVolumen);
                        $arDespacho->setDeclarado($declarado);
                        $em->persist($arDespacho);
                    }
                    $em->flush();  
                    return $this->redirect($this->generateUrl('tte_movimiento_despacho_detalle', array('codigoDespacho' => $codigoDespacho)));
                }
            }   
        }
        $dql = $em->getRepository('TransporteBundle:TteGuia')->guiasDespachoDql($codigoDespacho);
        $arGuias = $paginator->paginate($em->createQuery($dql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Movimiento/Despacho:detalle.html.twig', array(
            'arDespacho' => $arDespacho,
            'arGuias' => $arGuias,
            'form' => $form->createView()
            ));
    }    
    
    /**
     * @Route("/tte/movimiento/despacho/guia/agregar/{codigoDespacho}", name="tte_movimiento_despacho_guia_agregar")
     */   
    public function agrearGuiaAction(Request $request, $codigoDespacho) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');  
        $form = $this->formularioAgregarGuia(); 
        $form->handleRequest($request);
        $this->listaGuiasPendientes();    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($form->get('BtnAgregar')->isClicked()) {
                    $arrSeleccionados = $request->request->get('ChkSeleccionar');
                    if (count($arrSeleccionados) > 0) {
                        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
                        $arDespacho = $em->getRepository('TransporteBundle:TteDespacho')->find($codigoDespacho);
                        $guias = $arDespacho->getGuias();
                        $cantidad = $arDespacho->getCantidad();
                        $peso = $arDespacho->getPeso();
                        $pesoVolumen = $arDespacho->getPesoVolumen();
                        $declarado = $arDespacho->getDeclarado();
                        foreach ($arrSeleccionados AS $codigo) {
                            $arGuia = new \TransporteBundle\Entity\TteGuia;
                            $arGuia = $em->getRepository('TransporteBundle:TteGuia')->find($codigo);
                            $guias++;
                            $cantidad += $arGuia->getCantidad();
                            $peso += $arGuia->getPeso();
                            $pesoVolumen += $arGuia->getPesoVolumen();
                            $declarado += $arGuia->getDeclarado();  
                            $arGuia->setDespachoProveedorRel($arDespacho);
                            $arGuia->setEstadoDespachoProveedor(1);
                            $em->persist($arGuia);
                        }
                        $arDespacho->setGuias($guias);
                        $arDespacho->setCantidad($cantidad);
                        $arDespacho->setPeso($peso);
                        $arDespacho->setPesoVolumen($pesoVolumen);
                        $arDespacho->setDeclarado($declarado);
                        $em->persist($arDespacho);
                    }
                    $em->flush();            
                    echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";            
                }                
            }   
        }                     
        $arGuias = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Movimiento/Despacho:agregarGuia.html.twig', array(
            'arGuias' => $arGuias,
            'form' => $form->createView()
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
        $this->strListaDql = $em->getRepository('TransporteBundle:TteDespacho')->listaDql($this->getUser()->getCodigoEmpresaFk());
    }   
    
    private function listaGuiasPendientes() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteGuia')->guiaPendienteDespachoDql($this->getUser()->getCodigoEmpresaFk());
    }     

    private function formularioAgregarGuia() {   
        $session = new Session(); 
        $form = $this->createFormBuilder()                                                
            ->add('BtnAgregar', SubmitType::class, array('label'  => 'Agregar'))
            ->getForm();        
        return $form;
    }    
    
    private function formularioDetalle() {   
        $session = new Session(); 
        $form = $this->createFormBuilder()                                                
            ->add('BtnImprimir', SubmitType::class, array('label'  => 'Imprimir'))
            ->add('BtnDetalleEliminar', SubmitType::class, array('label'  => 'Eliminar'))
            ->getForm();        
        return $form;
    }     
    
}
