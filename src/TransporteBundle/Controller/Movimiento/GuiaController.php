<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use TransporteBundle\Form\Type\TteGuiaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GuiaController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/movimiento/guia/", name="tte_movimiento_guia")
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
            if ($form->get('BtnExcel')->isClicked()) {
                $this->filtrarLista($form, $request);
                $this->lista();
                $this->generarExcel();
            } 
            if ($request->request->get('OpImprimirEtiqueta')) {
                $codigoGuia = $request->request->get('OpImprimirEtiqueta');
                $objDespacho = new \TransporteBundle\Formato\Etiqueta();
                $objDespacho->Generar($em, "", $codigoGuia);

            }            
            
        }        
        
        $arEmpresa = $this->getUser()->getEmpresaRel();
        $alertaGuias = "";
        if(($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 50 ) {
            $alertaGuias = "Por favor solicitar mas remesas a sistemas@cotrascalsas.com";
        }
        $bloquearNuevo = 0;
        if(($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 0 ) {
            $bloquearNuevo = 1;
            $alertaGuias .= " ya no tiene mas consecutivos no puede crear mas guias";
        }
        
        $arGuias = $paginator->paginate($em->createQuery($this->strListaDql), $request->query->get('page', 1), 30);
        return $this->render('TransporteBundle:Movimiento/Guia:lista.html.twig', array(
            'arGuias' => $arGuias,
            'alertaGuias' => $alertaGuias,
            'bloquearNuevo' => $bloquearNuevo,
            'form' => $form->createView()
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
        $arEmpresa = $this->getUser()->getEmpresaRel();
        $alertaGuias = "";
        if(($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 50 ) {
            $alertaGuias = "Por favor solicitar mas remesas a sistemas@cotrascalsas.com";
        }
        $bloquearNuevo = 0;
        if(($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 0 ) {
            $bloquearNuevo = 1;
            $alertaGuias .= " ya no tiene mas consecutivos no puede crear mas guias";
        }         
        if ($form->isSubmitted()) {
            if ($form->isValid()) {  
                if($bloquearNuevo == 0) {
                    $arGuia = $form->getData();
                    if($arGuia->getEmpaqueEmpresaRel()) {
                        $arUsuario = $this->getUser();
                        $arCiudadOrigen = new \TransporteBundle\Entity\TteCiudad();
                        $arCiudadOrigen = $em->getRepository('TransporteBundle:TteCiudad')->find($arUsuario->getCodigoCiudadFk());                    
                        $arGuia->setCiudadOrigenRel($arCiudadOrigen);
                        $arGuia->setEmpaqueRel($arGuia->getEmpaqueEmpresaRel()->getEmpaqueRel());                    
                        $manejo = $arGuia->getEmpresaRel()->getPorcentajeManejo() * $arGuia->getDeclarado() / 100;                
                        if($arGuia->getEmpresaRel()->getManejoMinimoDespacho() > $manejo) {
                            $manejo = $arGuia->getEmpresaRel()->getManejoMinimoDespacho();
                        }
                        $pesoFacturar = 0;
                        if($arGuia->getPeso() >= $arGuia->getPesoVolumen()) {
                            $pesoFacturar = $arGuia->getPeso();
                        } else {
                            $pesoFacturar = $arGuia->getPesoVolumen();
                        }
                        $arGuia->setPesoFacturar($pesoFacturar);
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
        }               
        
        return $this->render('TransporteBundle:Movimiento/Guia:nuevo.html.twig', array(
                    'alertaGuias' => $alertaGuias,
                    'bloquearNuevo' => $bloquearNuevo,
                    'form' => $form->createView()));
    }    
    
    /**
     * @Route("/tte/movimiento/guia/detalle/{codigoGuia}", name="tte_movimiento_guia_detalle")
     */   
    public function detalleAction(Request $request, $codigoGuia) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');      
        $arGuia = new \TransporteBundle\Entity\TteGuia();        
        $arGuia = $em->getRepository('TransporteBundle:TteGuia')->find($codigoGuia);
        $form = $this->formularioDetalle($arGuia); 
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

            }   
        }
        //Linea del tiempo tomada de https://codepen.io/bsngr/pen/Ifvbi/
        $url ='http://localhost:8081/serviciowebbufalo/guiaestado.php?guia=' . $arGuia->getConsecutivo();        
        $json = file_get_contents($url);
        $array = json_decode($json,true);          
        return $this->render('TransporteBundle:Movimiento/Guia:detalle.html.twig', array(
            'arGuia' => $arGuia,
            'arrInformacionGuia' => $array,
            'form' => $form->createView()
            ));
    }    
    
    private function lista() {        
        $session = new Session;        
        $em = $this->getDoctrine()->getManager(); 
        $this->strListaDql = $em->getRepository('TransporteBundle:TteGuia')->listaDql(
                $this->getUser()->getCodigoEmpresaFk(),
                $session->get('filtroGuiaFechaDesde'),
                $session->get('filtroGuiaFechaHasta'),
                $session->get('filtroGuiaCodigo'),
                $session->get('filtroGuiaConsecutivo'),
                $session->get('filtroGuiaDocumento')
                );
    }    

    private function formularioLista() {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');               
        $dateFecha = new \DateTime('now');
        $strFechaDesde = $dateFecha->format('Y-m-d');        
        $strFechaHasta = $dateFecha->format('Y-m-d');
        if ($session->get('filtroGuiaFechaDesde') != "") {
            $strFechaDesde = $session->get('filtroGuiaFechaDesde');
        }
        if ($session->get('filtroGuiaFechaHasta') != "") {
            $strFechaHasta = $session->get('filtroGuiaFechaHasta');
        }
        $dateFechaDesde = date_create($strFechaDesde);
        $dateFechaHasta = date_create($strFechaHasta);

        $form = $this->createFormBuilder()
                ->add('codigo', NumberType::class)
                ->add('consecutivo', TextType::class)
                ->add('documento', TextType::class)
                ->add('fechaDesde', DateType::class, array('format' => 'yyyyMMdd', 'data' => $dateFechaDesde))
                ->add('fechaHasta', DateType::class, array('format' => 'yyyyMMdd', 'data' => $dateFechaHasta))
                ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
                ->add('BtnExcel', SubmitType::class, array('label' => 'Excel'))
                ->getForm();
        return $form;
    }   
    
    private function formularioDetalle($ar) {   
        $form = $this->createFormBuilder()                                                
            ->getForm();        
        return $form;
    }      
    
    private function filtrarLista($form) {
        $session = $this->get('session');
        $dateFechaDesde = $form->get('fechaDesde')->getData();
        $dateFechaHasta = $form->get('fechaHasta')->getData();
        $session->set('filtroGuiaFechaDesde', $dateFechaDesde->format('Y-m-d'));
        $session->set('filtroGuiaFechaHasta', $dateFechaHasta->format('Y-m-d'));
        $session->set('filtroGuiaCodigo', $form->get('codigo')->getData());
        $session->set('filtroGuiaConsecutivo', $form->get('consecutivo')->getData());
        $session->set('filtroGuiaDocumento', $form->get('documento')->getData());
    }    
    
    private function generarExcel() {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $objPHPExcel = new \PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("EMPRESA")
                ->setLastModifiedBy("EMPRESA")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('1')->getFont()->setBold(true);
        for ($col = 'A'; $col !== 'M'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal('left');
        }
        for($col = 'H'; $col !== 'M'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal('right');
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'GUIA')
                ->setCellValue('C1', 'FECHA')
                ->setCellValue('D1', 'DOCUMENTO')
                ->setCellValue('E1', 'DESTINATARIO')
                ->setCellValue('F1', 'ORIGEN')
                ->setCellValue('G1', 'DESTINO')
                ->setCellValue('H1', 'CANT')
                ->setCellValue('I1', 'PESO')
                ->setCellValue('J1', 'DECLARA')
                ->setCellValue('K1', 'FLETE')
                ->setCellValue('L1', 'MANEJO');


        $i = 2;
        $query = $em->createQuery($this->strListaDql);
        $arGuias = new \TransporteBundle\Entity\TteGuia();
        $arGuias = $query->getResult();
        foreach ($arGuias as $arGuia) {            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $arGuia->getCodigoGuiaPk())
                    ->setCellValue('B' . $i, $arGuia->getConsecutivo())
                    ->setCellValue('C' . $i, $arGuia->getFecha()->format('Y-m-d'))
                    ->setCellValue('D' . $i, $arGuia->getDocumento())
                    ->setCellValue('E' . $i, $arGuia->getDestinatario())
                    ->setCellValue('F' . $i, $arGuia->getCiudadOrigenRel()->getNombre())
                    ->setCellValue('G' . $i, $arGuia->getCiudadDestinoRel()->getNombre())
                    ->setCellValue('H' . $i, $arGuia->getCantidad())
                    ->setCellValue('I' . $i, $arGuia->getPeso())
                    ->setCellValue('J' . $i, $arGuia->getDeclarado())
                    ->setCellValue('K' . $i, $arGuia->getFlete())
                    ->setCellValue('L' . $i, $arGuia->getManejo());

            /*if ($arEmpleado->getCodigoZonaFk()) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU' . $i, $arEmpleado->getZonaRel()->getNombre());
            }*/
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Guias');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Guias.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;
        ini_set('memory_limit', '512m');
        set_time_limit(60);
    }    
    
}
