<?php
namespace TransporteBundle\Formato;
class Etiqueta extends \FPDF {
    public static $em;
    public static $codigoDespacho;
    
    public function Generar($em, $codigoDespacho) {        
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoDespacho = $codigoDespacho;
        $pdf = new Etiqueta();
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
        $this->Image('imagenes/logo.jpg', 12, 13, 35, 17);        
        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles() {

    }

    public function Body($pdf) {
        $arGuias = new \TransporteBundle\Entity\TteGuia;
        $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoDespachoProveedorFk' => self::$codigoDespacho));                
        foreach ($arGuias as $arGuia) {
           $pdf->AddPage(); 
        }
        
    }

    public function Footer() {
        $this->SetFont('Arial','', 8);  
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }    
}

?>
