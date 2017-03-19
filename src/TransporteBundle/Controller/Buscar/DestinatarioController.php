<?php

namespace TransporteBundle\Controller\Buscar;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteGuiaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class DestinatarioController extends Controller
{
    var $strListaDql = "";
    
    /**
     * @Route("/tte/buscar/destinatario/", name="tte_buscar_destinatario")
     */
    public function buscarAction(Request $request) {
        $em = $this->getDoctrine()->getManager();        
        $paginator  = $this->get('knp_paginator');
        $form = $this->formularioLista();
        $form->handleRequest($request);
        $this->lista();
        if ($form->isValid()) {            
            if($form->get('BtnFiltrar')->isClicked()) {
                $this->filtrarLista($form);
                $this->lista();
            }
        }
        $arDestinatarios = $paginator->paginate($em->createQuery($this->strDqlLista), $request->query->get('page', 1), 20);
        return $this->render('TransporteBundle:Buscar:destinatario.html.twig', array(
            'arDestinatarios' => $arDestinatarios,
            'form' => $form->createView()
            ));
    }        
    
    private function lista() {    
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $this->strDqlLista = $em->getRepository('TransporteBundle:TteDestinatario')->listaDql(
                $this->getUser()->getCodigoEmpresaFk(),
                $session->get('codigoCodigoDestinatario'),                
                $session->get('codigoNombreDestinatario')
                ); 
    }       
    
    private function formularioLista() {   
        $session = new Session(); 
        $form = $this->createFormBuilder()                                                
            ->add('TxtNombre', TextType::class, array('label'  => 'Nombre','data' => $session->get('codigoDestinatario')))
            ->add('TxtCodigo', TextType::class, array('label'  => 'Codigo','data' => $session->get('nombreDestinatario')))                            
            ->add('BtnFiltrar', SubmitType::class, array('label'  => 'Filtrar'))
            ->getForm();        
        return $form;
    }           

    private function filtrarLista($form) {
        $session = new Session();  
        $session->set('codigoDestinatario', $form->get('TxtCodigo')->getData());
        $session->set('nombreDestinatario', $form->get('TxtNombre')->getData());        
    }         

    
}
