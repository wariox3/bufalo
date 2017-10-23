<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteDespachoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class DespachoController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/movimiento/despacho/", name="tte_movimiento_despacho")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator'); 
        $form = $this->formularioLista();
        $form->handleRequest($request);        
        $this->lista();       
        if ($form->isValid()) {
            if ($form->get('BtnFiltrar')->isClicked()) {
                $this->filtrarLista($form, $request);
                $this->lista();
            }
        }        
        $arDespachos = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Movimiento/Despacho:lista.html.twig', array(
            'arDespachos' => $arDespachos,
            'form' => $form->createView()
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
        $form = $this->formularioDetalle($arDespacho); 
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($form->get('BtnImprimir')->isClicked()) {
                    $objDespacho = new \TransporteBundle\Formato\Despacho();
                    $objDespacho->Generar($em, $codigoDespacho);
                    if($arDespacho->getEstadoImpreso() == 0) {
                        $arDespacho->setEstadoImpreso(1);
                        $em->persist($arDespacho);
                        $em->flush();
                    }
                }
                if ($form->get('BtnImprimirEtiquetas')->isClicked()) {
                    $objDespacho = new \TransporteBundle\Formato\Etiqueta();
                    $objDespacho->Generar($em, $codigoDespacho, "");
                }      
                if ($form->get('BtnImprimirRelacionDocumentos')->isClicked()) {
                    $objDespacho = new \TransporteBundle\Formato\DespachoRelacionDocumentos();
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
        $session = new Session;        
        $em = $this->getDoctrine()->getManager(); 
        $this->strListaDql = $em->getRepository('TransporteBundle:TteDespacho')->listaDql(
                $this->getUser()->getCodigoEmpresaFk(),
                $session->get('filtroDespachoFechaDesde'),
                $session->get('filtroDespachoFechaHasta'),
                $session->get('filtroGuiaCodigo')
                );                        
    }   
    
    private function listaGuiasPendientes() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteGuia')->guiaPendienteDespachoDql($this->getUser()->getCodigoEmpresaFk());
    }     

    private function formularioLista() {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');               
        $dateFecha = new \DateTime('now');
        $strFechaDesde = $dateFecha->format('Y-m-d');        
        $strFechaHasta = $dateFecha->format('Y-m-d');
        if ($session->get('filtroDespachoFechaDesde') != "") {
            $strFechaDesde = $session->get('filtroDespachoFechaDesde');
        }
        if ($session->get('filtroDespachoFechaHasta') != "") {
            $strFechaHasta = $session->get('filtroDespachoFechaHasta');
        }
        $dateFechaDesde = date_create($strFechaDesde);
        $dateFechaHasta = date_create($strFechaHasta);

        $form = $this->createFormBuilder()
                ->add('codigo', NumberType::class)                
                ->add('fechaDesde', DateType::class, array('format' => 'yyyyMMdd', 'data' => $dateFechaDesde))
                ->add('fechaHasta', DateType::class, array('format' => 'yyyyMMdd', 'data' => $dateFechaHasta))
                ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
                ->getForm();
        return $form;
    }    
    
    private function formularioAgregarGuia() {   
        $session = new Session(); 
        $form = $this->createFormBuilder()                                                
            ->add('BtnAgregar', SubmitType::class, array('label'  => 'Agregar'))
            ->getForm();        
        return $form;
    }    
    
    private function formularioDetalle($ar) {   
        $session = new Session(); 
        $arrBotonImprimir = array('label' => 'Imprimir', 'disabled' => false);
        $arrBotonImprimirRelacionDocumentos = array('label' => 'Imprimir relacion documentos', 'disabled' => false);
        $arrBotonDetalleEliminar = array('label' => 'Eliminar', 'disabled' => false);
        if($ar->getEstadoImpreso() == 1) {
            $arrBotonDetalleEliminar['disabled'] = true;
        }
        $form = $this->createFormBuilder()                                                
            ->add('BtnImprimir', SubmitType::class, $arrBotonImprimir)
            ->add('BtnImprimirRelacionDocumentos', SubmitType::class, $arrBotonImprimirRelacionDocumentos)
            ->add('BtnImprimirEtiquetas', SubmitType::class, array('label'  => 'Imprimir etiquetas'))
            ->add('BtnDetalleEliminar', SubmitType::class, $arrBotonDetalleEliminar)
            ->getForm();        
        return $form;
    }     
    
    private function filtrarLista($form) {
        $session = $this->get('session');
        $dateFechaDesde = $form->get('fechaDesde')->getData();
        $dateFechaHasta = $form->get('fechaHasta')->getData();
        $session->set('filtroDespachoFechaDesde', $dateFechaDesde->format('Y-m-d'));
        $session->set('filtroDespachoFechaHasta', $dateFechaHasta->format('Y-m-d'));
        $session->set('filtroGuiaCodigo', $form->get('codigo')->getData());        
    }    
    
}
