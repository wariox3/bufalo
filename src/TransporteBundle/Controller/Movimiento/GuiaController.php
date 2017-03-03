<?php

namespace TransporteBundle\Controller\Movimiento;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TransporteBundle\Form\Type\TteGuiaType;

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
    
    /**
     * @Route("/tte/movimiento/guia/nuevo/{codigoGuia}", name="tte_movimiento_guia_nuevo")
     */
    public function nuevoAction(Request $request, $codigoGuia = 0) {
        $em = $this->getDoctrine()->getManager();        
        $arGuia = new \TransporteBundle\Entity\TteGuia();
        $form = $this->createForm(TteGuiaType::class, $arGuia);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $arUsuario = $this->get('security.token_storage')->getToken()->getUser();
            $arLicencia = $form->getData();
            $arrControles = $request->request->All();

            if ($arrControles['form_txtNumeroIdentificacion'] != '') {
                $arEmpleado = new \Brasa\RecursoHumanoBundle\Entity\RhuEmpleado();
                $arEmpleado = $em->getRepository('BrasaRecursoHumanoBundle:RhuEmpleado')->findOneBy(array('numeroIdentificacion' => $arrControles['form_txtNumeroIdentificacion']));
                if (count($arEmpleado) > 0) {
                    // fin validacion
                    $arLicencia->setEmpleadoRel($arEmpleado);
                    if ($arLicencia->getFechaDesde() <= $arLicencia->getFechaHasta()) {
                        if ($em->getRepository('BrasaRecursoHumanoBundle:RhuIncapacidad')->validarFecha($arLicencia->getFechaDesde(), $arLicencia->getFechaHasta(), $arEmpleado->getCodigoEmpleadoPk(), "")) {
                            if ($em->getRepository('BrasaRecursoHumanoBundle:RhuLicencia')->validarFecha($arLicencia->getFechaDesde(), $arLicencia->getFechaHasta(), $arEmpleado->getCodigoEmpleadoPk(), $arLicencia->getCodigoLicenciaPk())) {
                                if ($arEmpleado->getFechaContrato() <= $arLicencia->getFechaDesde()) {
                                    $arLicencia->setCentroCostoRel($arEmpleado->getCentroCostoRel());
                                    $intDias = $arLicencia->getFechaDesde()->diff($arLicencia->getFechaHasta());
                                    $intDias = $intDias->format('%a');
                                    $intDias = $intDias + 1;
                                    $arLicencia->setCantidad($intDias);
                                    $arLicencia->setMaternidad($arLicencia->getLicenciaTipoRel()->getMaternidad());
                                    if ($codigoLicencia == 0) {
                                        $arLicencia->setCodigoUsuario($arUsuario->getUserName());
                                        $arContrato = new \Brasa\RecursoHumanoBundle\Entity\RhuContrato();
                                        if ($arEmpleado->getCodigoContratoActivoFk() != '') {
                                            $arContrato = $em->getRepository('BrasaRecursoHumanoBundle:RhuContrato')->find($arEmpleado->getCodigoContratoActivoFk());
                                        } else {
                                            $arContrato = $em->getRepository('BrasaRecursoHumanoBundle:RhuContrato')->find($arEmpleado->getCodigoContratoUltimoFk());
                                        }
                                        $arLicencia->setContratoRel($arContrato);
                                    }
                                    $em->persist($arLicencia);
                                    $em->flush();
                                    if ($form->get('guardarnuevo')->isClicked()) {
                                        return $this->redirect($this->generateUrl('brs_rhu_licencias_nuevo', array('codigoLicencia' => 0)));
                                    } else {
                                        return $this->redirect($this->generateUrl('brs_rhu_licencias_lista'));
                                    }
                                } else {
                                    $objMensaje->Mensaje("error", "La fecha de inicio del contrato es mayor a la licencia");
                                }
                            } else {
                                $objMensaje->Mensaje("error", "Existe otra licencia en este rango de fechas");
                            }
                        } else {
                            $objMensaje->Mensaje("error", "Hay incapacidades que se cruzan con la fecha de la licencia");
                        }
                    } else {
                        $objMensaje->Mensaje("error", "La fecha desde debe ser inferior o igual a la fecha hasta");
                    }
                } else {
                    $objMensaje->Mensaje("error", "El empleado no existe");
                }
            }
        }

        return $this->render('TransporteBundle:Movimiento/Guia:nuevo.html.twig', array(
                    'form' => $form->createView()));
    }    
    
}
