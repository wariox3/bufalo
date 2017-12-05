<?php

namespace TransporteBundle\Controller\Reporte;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use TransporteBundle\Form\Type\TteGuiaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NovedadPendienteController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/reporte/novedad/pendiente/", name="tte_reporte_novedad_pendiente")
     */   
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');              
        $form = $this->formularioLista();
        $form->handleRequest($request);          
        $arrNovedades = null;
        $nitEmpresa = $arEmpresa = $this->getUser()->getEmpresaRel()->getNit();
        if ($form->isValid()) {
            //$url ='http://localhost:8081/serviciowebbufalo/reporteguia.php?empresa=1';
            $url ='http://localhost:8081/serviciowebbufalo/reportenovedadpendiente.php?empresa=' . $nitEmpresa;
            $json = file_get_contents($url);
            $array = json_decode($json,true);  
            $arrNovedades = $array['novedades'];            
            if ($form->get('BtnExcel')->isClicked()) {                
                $this->generarExcel($arrNovedades);
            }                      
        }                              
        return $this->render('TransporteBundle:Reporte/Novedad:pendiente.html.twig', array(
            'arNovedades' => $arrNovedades,
            'form' => $form->createView()
            ));
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
                ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
                ->add('BtnExcel', SubmitType::class, array('label' => 'Excel'))
                ->getForm();
        return $form;
    }           
    
    private function generarExcel($arrGuias) {
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
        /*for($col = 'G'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal('right');
        }*/
        $objPHPExcel->setActiveSheetIndex(0)                
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'FECHA')
                ->setCellValue('C1', 'NOVEDAD')
                ->setCellValue('D1', 'GUIA');


        $i = 2;
        foreach ($arrGuias as $arGuia) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $arGuia['ID'])
                    ->setCellValue('B' . $i, $arGuia['FhNovedad'])
                    ->setCellValue('C' . $i, $arGuia['NmNovedad'])
                    ->setCellValue('D' . $i, 'Guia');
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
