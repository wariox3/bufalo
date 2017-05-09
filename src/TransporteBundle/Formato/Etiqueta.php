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
        $pdf = new Etiqueta('P','mm',array(80,50));
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
        $this->Image('imagenes/logo.jpg', 1, 1, 10, 10);        
        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles() {

    }

    public function Body($pdf) {
        $arGuias = new \TransporteBundle\Entity\TteGuia;
        $arGuias = self::$em->getRepository('TransporteBundle:TteGuia')->findBy(array('codigoDespachoProveedorFk' => self::$codigoDespacho));                
        foreach ($arGuias as $arGuia) {
           $pdf->SetFont('Arial', 'B', 5);
           $pdf->Text(15, 10, "INFORMACION DESTINATARIO");
           $pdf->SetFont('Arial', '', 5);
           $pdf->Text(2, 15, "Cedula:" . $arGuia->getIdentificacion());
           $pdf->Text(30, 15, "Documento:" . $arGuia->getDocumento());
           $pdf->Text(2, 18, "Destinatario:" . $arGuia->getDestinatario());
           $pdf->Text(2, 21, "Direccion:" . $arGuia->getDireccion());
           $pdf->Text(2, 24, "Telefono:" . $arGuia->getTelefono());
           $pdf->Text(2, 27, "Destino:" . $arGuia->getCiudadDestinoRel()->getNombre());
           $pdf->AddPage(); 
        }
        
    }

    public function Footer() {
        $this->SetFont('Arial','', 8);  
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }    
}

?>
