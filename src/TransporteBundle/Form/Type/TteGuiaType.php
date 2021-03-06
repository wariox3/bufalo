<?php
namespace TransporteBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TteGuiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder                  
            ->add('ciudadDestinoRel', EntityType::class, array(
                'class' => 'TransporteBundle:TteCiudad',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.nombre', 'ASC');},
                'choice_label' => 'nombre',
                'required' => true))                 
            ->add('empaqueEmpresaRel', EntityType::class, array(
                'class' => 'TransporteBundle:TteEmpaqueEmpresa',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('ee')
                    ->leftJoin('ee.empaqueRel', 'e')
                    ->where('ee.codigoEmpresaFk = :codigoEmpresa')
                    ->setParameter('codigoEmpresa', $options['data']->getEmpresaRel()->getCodigoEmpresaPk())
                    ->orderBy('ee.codigoEmpaqueFk', 'ASC');},
                'choice_label' => 'empaqueRel.nombre',
                'required' => true))                                             
            ->add('identificacion', TextType::class, array('required' => false))
            ->add('destinatario', TextType::class, array('required' => true))                
            ->add('nombre1', TextType::class, array('required' => false))                
            ->add('nombre2', TextType::class, array('required' => false))                
            ->add('apellido1', TextType::class, array('required' => false))                
            ->add('apellido2', TextType::class, array('required' => false))                
            ->add('direccion', TextType::class, array('required' => true))                
            ->add('barrio', TextType::class, array('required' => false))                
            ->add('telefono', TextType::class, array('required' => false))                    
            ->add('correo', TextType::class, array('required' => false))
            ->add('cantidad', NumberType::class, array('required' => false))
            ->add('peso', NumberType::class, array('required' => true))
            ->add('pesoVolumen', NumberType::class, array('required' => false))
            ->add('declarado', NumberType::class, array('required' => false))
            ->add('documento', TextType::class, array('required' => false))
            ->add('devolverDocumento', CheckboxType::class, array('required' => false))                            
            ->add('observacion', TextareaType::class, array('required' => false))            
            ->add('documentoRelacion', TextareaType::class, array('required' => false))
            ->add('zona', TextType::class, array('required' => false))
            ->add('despachador', TextType::class, array('required' => false))
            ->add('empaqueReferencia', TextType::class, array('required' => false))
            ->add('guardar', SubmitType::class)
            ->add('guardarnuevo', SubmitType::class, array('label'  => 'Guardar y Nuevo'));        
    }
 
    public function getBlockPrefix()
    {
        return 'form';
    }
}

