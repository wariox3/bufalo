<?php
namespace TransporteBundle\Formato;
use BG\BarcodeBundle\Util\Base1DBarcode as barCode;
use BG\BarcodeBundle\Util\Base2DBarcode as matrixCode;

class Etiqueta extends \FPDF {
    public static $em;
    public static $codigoDespacho;
    
    public function Generar($em, $codigoDespacho) {        
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoDespacho = $codigoDespacho;
        $pdf = new Etiqueta('L','mm',array(50,75));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Etiquetas$codigoDespacho.pdf", 'D');                
    } 
    
    public function Header() {
        $arDespacho = new \TransporteBundle\Entity\TteDespacho();
        $arDespacho = self::$em->getRepository('TransporteBundle:TteDespacho')->find(self::$codigoDespacho);                        
        $arEmpresa = new \TransporteBundle\Entity\TteEmpresa();
        $arEmpresa = $arDespacho->getEmpresaRel();        
        $this->Image('imagenes/logo.jpg', 5, 5, 10, 10);        
        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles() {

    }

    public function Body($pdf) {
        //https://github.com/paterik/BGBarcodeBundle
        $ruta = "C:\\xampp\\htdocs\\img2\\";
        $ruta = "/var/www/imgbarras/";
        $myBarcode = new barCode();
        
        $myBarcode->savePath = $ruta;                 
        
        $arGuias = new \TransporteBundle\Entity\TteGuia;
        $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoDespachoProveedorFk' => self::$codigoDespacho));                
        foreach ($arGuias as $arGuia) {
            $bcPathAbs = $myBarcode->getBarcodePNGPath($arGuia->getConsecutivo(), 'C39', 1.75, 45);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Text(20, 10, "INFORMACION DESTINATARIO");
            $pdf->SetFont('Arial', '', 7);
            $pdf->Text(15, 18, "NIT:" . $arGuia->getIdentificacion());
            $pdf->Text(40, 18, "DOC:" . $arGuia->getDocumento());
            $pdf->Text(15, 21, "NOMBRE:" . utf8_decode($arGuia->getDestinatario()));
            $pdf->Text(15, 24, "DIR:" . $arGuia->getDireccion());
            $pdf->Text(15, 27, "TEL:" . $arGuia->getTelefono());
            $pdf->Text(15, 30, "DESTINO:" . $arGuia->getCiudadDestinoRel()->getNombre());          
            //$pdf->Text(30, 40, "*" . $arGuia->getConsecutivo() . "*");
            $pdf->Image($ruta . 'C39_'.$arGuia->getConsecutivo().'.png', 15, 35, 50, 10);           
            $pdf->AddPage(); 
        }
        
    }

    public function Footer() {
        $this->SetFont('Arial','', 8);  
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }    
}

?>
