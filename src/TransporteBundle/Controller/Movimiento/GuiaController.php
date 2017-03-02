<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GuiaController extends Controller
{
    /**
     * @Route("/tte/movimiento/guia/", name="tte_movimiento_guia")
     */   
    public function listaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $arGuias = new \TransporteBundle\Entity\TteGuia();
        $arGuias = $em->getRepository('TransporteBundle:TteGuia')->findAll();
        return $this->render('TransporteBundle:Movimiento/Guia:lista.html.twig', array(
            'arGuias' => $arGuias
            ));
    }
}
