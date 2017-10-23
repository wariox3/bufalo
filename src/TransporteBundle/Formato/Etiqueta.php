<?php
namespace TransporteBundle\Formato;
use BG\BarcodeBundle\Util\Base1DBarcode as barCode;
use BG\BarcodeBundle\Util\Base2DBarcode as matrixCode;

class Etiqueta extends \FPDF {
    public static $em;
    public static $codigoDespacho;
    public static $codigoGuia;
    
    public function Generar($em, $codigoDespacho, $codigoGuia = "") {        
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoDespacho = $codigoDespacho;
        self::$codigoGuia = $codigoGuia;
        $pdf = new Etiqueta('L','mm',array(50,75));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Etiquetas$codigoDespacho.pdf", 'D');                
    } 
    
    public function Header() {
        //$arDespacho = new \TransporteBundle\Entity\TteDespacho();
        //$arDespacho = self::$em->getRepository('TransporteBundle:TteDespacho')->find(self::$codigoDespacho);                        
        //$arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
        //$arEmpresa = $arDespacho->getEmpresaRel();        
        //$this->Image('imagenes/logo.jpg', 5, 5, 10, 10);        
        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles() {

    }

    public function Body($pdf) {
        //https://github.com/paterik/BGBarcodeBundle
        // instalar php-gd es indispensable
        $ruta = "C:\\xampp\\htdocs\\img2\\";
        $ruta = "/var/www/imgbarras/";
        $myBarcode = new barCode();        
        $myBarcode->savePath = $ruta;
        $arGuias = new \TransporteBundle\Entity\TteGuia;
        if(self::$codigoDespacho != "") {
            $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoDespachoProveedorFk' => self::$codigoDespacho));                
        }
        if(self::$codigoGuia != "") {
            $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoGuiaPk' => self::$codigoGuia));                
        }                
        foreach ($arGuias as $arGuia) {
            $bcPathAbs = $myBarcode->getBarcodePNGPath($arGuia->getConsecutivo(), 'C39', 1.75, 45);
            for ($i = 1; $i <= $arGuia->getCantidad(); $i++) {
                $pdf->SetFont('Arial', 'B', 12);                
                $pdf->Text(21, 5, "COTRASCAL S.A.S");
                $pdf->SetFont('Arial', 'B', 7);                
                $pdf->Text(5, 10, 'REMITE:' . $arGuia->getEmpresaRel()->getNombre());
                $pdf->Text(20, 14, "INFORMACION DESTINATARIO");                
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Text(65, 14, $i . '/' . $arGuia->getCantidad());
                $pdf->SetFont('Arial', '', 7);
                $pdf->Text(5, 18, "NIT:" . $arGuia->getIdentificacion());
                $pdf->Text(40, 18, "DOC:" . $arGuia->getDocumento());
                $pdf->Text(5, 21, "NOMBRE:" . utf8_decode($arGuia->getDestinatario()));
                $pdf->Text(5, 24, "DIR:" . $arGuia->getDireccion());
                $pdf->Text(5, 27, "TEL:" . $arGuia->getTelefono());
                $pdf->Text(5, 30, "DESTINO:" . $arGuia->getCiudadDestinoRel()->getNombre());
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Text(30, 47, $arGuia->getConsecutivo());
                $pdf->Image($ruta . 'C39_'.$arGuia->getConsecutivo().'.png', 15, 31, 50, 10);           
                $pdf->AddPage();
            }             
        }
        
    }

    public function Footer() {
        $this->SetFont('Arial','', 8);  
        
    }    
}

?>
