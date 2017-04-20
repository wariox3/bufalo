<?php

namespace TransporteBundle\Controller\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteEmpresaType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class EmpresaController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/base/empresa/", name="tte_base_empresa")
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
                            $arEmpresaEliminar = $em->getRepository('TransporteBundle:TteEmpresa')->find($codigo);                                
                            $em->remove($arEmpresaEliminar);                                                            
                        }
                        $em->flush();
                    }                    
                }
            }   
        }
        $arEmpresas = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 50);
        return $this->render('TransporteBundle:Base/Empresa:lista.html.twig', array(
            'arEmpresas' => $arEmpresas,
            'form' => $form->createView()
            ));
    }
    
    /**
     * @Route("/tte/base/empresa/nuevo/{codigoEmpresa}", name="tte_base_empresa_nuevo")
     */
    public function nuevoAction(Request $request, $codigoEmpresa = 0) {
        $em = $this->getDoctrine()->getManager();        
        $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
        if ($codigoEmpresa != 0) {
            $arEmpresa = $em->getRepository('TransporteBundle:TteEmpresa')->find($codigoEmpresa);            
        } else {
            $arUsuario = $this->getUser();            
            $arEmpresa->setEmpresaRel($arUsuario->getEmpresaRel());
        }        
        $form = $this->createForm(TteEmpresaType::class, $arEmpresa);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $arEmpresa = $form->getData();
                $em->persist($arEmpresa);
                $em->flush();
                if ($form->get('guardarnuevo')->isClicked()) {
                    return $this->redirect($this->generateUrl('tte_base_empresa_nuevo', array('codigoEmpresa' => 0)));
                } else {
                    return $this->redirect($this->generateUrl('tte_base_empresa'));
                    //return $this->redirect($this->generateUrl('brs_tur_movimiento_pedido_detalle', array('codigoPedido' => $arPedido->getCodigoPedidoPk())));
                }                
            }
        }
        return $this->render('TransporteBundle:Base/Empresa:nuevo.html.twig', array(
                    'form' => $form->createView()));
    }    
    
    /**
     * @Route("/tte/base/empresa/detalle/{codigoEmpresa}", name="tte_base_empresa_detalle")
     */   
    public function detalleAction(Request $request, $codigoEmpresa) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
        $arEmpresa = $em->getRepository('TransporteBundle:TteEmpresa')->find($codigoEmpresa);
        $form = $this->formularioDetalle(); 
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) { 
                if ($form->get('BtnEliminarTodo')->isClicked()) {
                    $strSql = "DELETE FROM tte_precio_detalle WHERE codigo_empresa_fk = " . $codigoEmpresa;
                    $em->getConnection()->executeQuery($strSql);                    
                }
                return $this->redirect($this->generateUrl('tte_base_empresa_detalle', array('codigoEmpresa' => $codigoEmpresa)));
            }   
        }
        $dql = $em->getRepository('TransporteBundle:TtePrecioDetalle')->listaDql($codigoEmpresa);
        $arPrecioDetalles = $paginator->paginate($em->createQuery($dql), $request->query->get('page', 1), 1000);
        return $this->render('TransporteBundle:Base/Empresa:detalle.html.twig', array(
            'arEmpresa' => $arEmpresa,
            'arPrecioDetalles' => $arPrecioDetalles,
            'form' => $form->createView()
            ));
    }      
    
    /**
     * @Route("/tte/base/empresa/cargar/precio/{codigoEmpresa}", name="tte_base_empresa_cargar_precio")
     */
    public function cargarAction(Request $request, $codigoEmpresa) {
        $em = $this->getDoctrine()->getManager();        
        $form = $this->createFormBuilder()
            ->add('attachment', FileType::class)
            ->add('BtnCargar', SubmitType::class, array('label'  => 'Cargar'))
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()) {
            if($form->get('BtnCargar')->isClicked()) {                
                set_time_limit(0);
                ini_set("memory_limit", -1);
                $form['attachment']->getData()->move("/var/www/temporal/", "archivo.xls");
                $ruta = "/var/www/temporal/archivo.xls";
                $arrCarga = array();
                $objPHPExcel = \PHPExcel_IOFactory::load($ruta);
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $worksheetTitle     = $worksheet->getTitle();
                    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                    $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                    $nrColumns = ord($highestColumn) - 64;
                    for ($row = 2; $row <= $highestRow; ++ $row) {
                        $arrCarga[] = array(
                            'empresa' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                            'origen' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                            'destino' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                            'producto' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                            'vrKilo' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                            'vrUnidad' => $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    }
                }
                $error = "";
                foreach ($arrCarga as $carga) {                    
                    $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
                    $arEmpresa = $em->getRepository('TransporteBundle:TteEmpresa')->find($carga['empresa']);
                    $arEmpaque = new \TransporteBundle\Entity\TteEmpaque();
                    $arEmpaque = $em->getRepository('TransporteBundle:TteEmpaque')->find($carga['producto']);
                    $arCiudadOrigen = new \TransporteBundle\Entity\TteCiudad();
                    $arCiudadOrigen = $em->getRepository('TransporteBundle:TteCiudad')->find($carga['origen']);                    
                    $arCiudadDestino = new \TransporteBundle\Entity\TteCiudad();
                    $arCiudadDestino = $em->getRepository('TransporteBundle:TteCiudad')->find($carga['destino']);                                        
                    if($arEmpresa && $arEmpaque && $arCiudadOrigen && $arCiudadDestino) {
                        $arPrecioDetalle = new \TransporteBundle\Entity\TtePrecioDetalle();
                        $arPrecioDetalle->setEmpresaRel($arEmpresa);
                        $arPrecioDetalle->setEmpaqueRel($arEmpaque);
                        $arPrecioDetalle->setCiudadOrigenRel($arCiudadOrigen);
                        $arPrecioDetalle->setCiudadRel($arCiudadDestino);
                        $arPrecioDetalle->setVrKilo($carga['vrKilo']);
                        $arPrecioDetalle->setVrUnidad($carga['vrUnidad']);
                        $em->persist($arPrecioDetalle);
                    }
                }
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";                
            }
        }
        return $this->render('TransporteBundle:Base/Empresa:cargarPrecio.html.twig', array(
            'form' => $form->createView()
            ));
    }    
    
    private function lista() {        
        $em = $this->getDoctrine()->getManager();                  
        $this->strListaDql = $em->getRepository('TransporteBundle:TteEmpresa')->listaDQL();
    }    

    private function formularioLista() {
        $em = $this->getDoctrine()->getManager();
        $session = new session;        
        $form = $this->createFormBuilder()
                ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
                ->getForm();
        return $form;
    }   
    
    private function formularioDetalle() {   
        $session = new Session(); 
        $form = $this->createFormBuilder()   
            ->add('BtnEliminarTodo', SubmitType::class, array('label' => 'Eliminar todo'))
            ->getForm();        
        return $form;
    }     
    
}
