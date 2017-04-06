<?php
namespace TransporteBundle\Formato;
class Despacho extends \FPDF {
    public static $em;
    public static $codigoDespacho;
    
    public function Generar($em, $codigoDespacho) {        
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoDespacho = $codigoDespacho;
        $pdf = new Despacho();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Despacho$codigoDespacho.pdf", 'D');                
    } 
    
    public function Header() {
        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
        $arDespacho = self::$em->getRepository('TransporteBundle:TteDespacho')->find(self::$codigoDespacho);        
        $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
        $arEmpresa = $arDespacho->getEmpresaRel();
        $this->SetFillColor(200, 200, 200);        
        $this->SetFont('Arial','B',10);
        //Logo
        
        $this->Image('imagenes/logo.jpg', 12, 13, 35, 17);
        //INFORMACIÓN EMPRESA
        $this->SetXY(50, 10);
        $this->Cell(150, 7, utf8_decode("RELACION DESPACHO"), 0, 0, 'C', 1);
        $this->SetXY(50, 18);
        $this->SetFont('Arial','B',9);
        $this->Cell(20, 4, "EMPRESA:", 0, 0, 'L', 1);
        $this->Cell(100, 4, $arEmpresa->getNombre(), 0, 0, 'L', 0);
        $this->SetXY(50, 22);
        $this->Cell(20, 4, "NIT:", 0, 0, 'L', 1);
        $this->Cell(100, 4, $arEmpresa->getNit(), 0, 0, 'L', 0);
        $this->SetXY(50, 26);
        $this->Cell(20, 4, utf8_decode("DIRECCIÓN:"), 0, 0, 'L', 1);
        $this->Cell(100, 4, $arEmpresa->getDireccion(), 0, 0, 'L', 0);
        $this->SetXY(50, 30);
        $this->Cell(20, 4, utf8_decode("TELÉFONO:"), 0, 0, 'L', 1);
        $this->Cell(100, 4, $arEmpresa->getTelefono(), 0, 0, 'L', 0);        


        $this->SetFillColor(236, 236, 236);        
        $this->SetFont('Arial','B',10);
        //linea 1
        $this->SetXY(10, 40);
        $this->SetFillColor(200, 200, 200); 
        $this->SetFont('Arial','B',8);
        $this->Cell(30, 6, utf8_decode("NUMERO:") , 1, 0, 'L', 1);
        $this->SetFillColor(272, 272, 272); 
        $this->SetFont('Arial','',8);
        $this->Cell(30, 6, $arDespacho->getCodigoDespachoPk(), 1, 0, 'R', 1);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(30, 6, "FECHA:" , 1, 0, 'L', 1);
        $this->SetFont('Arial','',8);
        $this->SetFillColor(272, 272, 272); 
        $this->Cell(100, 6, $arDespacho->getFecha()->format('Y-m-d'), 1, 0, 'L', 1);

        

        $this->EncabezadoDetalles();
        
    }

    public function EncabezadoDetalles() {
        $this->Ln(12);
        $header = array('NUMERO','DOCUMENTO','DESTINATARIO', 'DIRECCION', 'DESTINO', 'UND','PESO', 'FLETE', 'DECLARA');
        $this->SetFillColor(236, 236, 236);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 5);

        //creamos la cabecera de la tabla.
        $w = array(15, 20, 55, 15, 35, 10, 10, 15, 15);
        for ($i = 0; $i < count($header); $i++)
            if ($i == 0 || $i == 1)
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'L', 1);
            else
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 1);

        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Ln(4);
    }

    public function Body($pdf) {
        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
        $arDespacho = self::$em->getRepository('TransporteBundle:TteDespacho')->find(self::$codigoDespacho);        
        $arGuias = new \TransporteBundle\Entity\TteGuia;
        $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoDespachoProveedorFk' => self::$codigoDespacho));        
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 5);
        $var = 0;
        foreach ($arGuias as $arGuia) {             
            $pdf->Cell(15, 4, $arGuia->getConsecutivo(), 1, 0, 'L');
            $pdf->Cell(20, 4, $arGuia->getDocumento(), 1, 0, 'L');             
            $pdf->Cell(55, 4, utf8_decode($arGuia->getDestinatario()), 1, 0, 'L');
            $pdf->Cell(15, 4, substr($arGuia->getDireccion(), 0, 10), 1, 0, 'L');
            $pdf->Cell(35, 4, utf8_decode($arGuia->getCiudadDestinoRel()->getNombre()), 1, 0, 'L');
            $pdf->Cell(10, 4, number_format($arGuia->getCantidad(), 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(10, 4, number_format($arGuia->getPeso(), 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(15, 4, number_format($arGuia->getFlete(), 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(15, 4, number_format($arGuia->getDeclarado(), 0, '.', ','), 1, 0, 'R');
            $var += 0;
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
            
        }
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(175, 5, "NUMERO GUIAS: ", 1, 0, 'R');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(15, 5, number_format($arDespacho->getGuias(),0, '.', ','), 1, 0, 'R');
        
    }

    public function Footer() {
        $this->SetFont('Arial','', 8);  
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }    
}

?>