<?php
namespace TransporteBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('empaqueRel', EntityType::class, array(
                'class' => 'TransporteBundle:TteEmpaque',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                    ->orderBy('e.nombre', 'ASC');},
                'choice_label' => 'nombre',
                'required' => true))                                             
            ->add('destinatario', TextType::class, array('required' => false))                
            ->add('nombre1', TextType::class, array('required' => false))                
            ->add('nombre2', TextType::class, array('required' => false))                
            ->add('apellido1', TextType::class, array('required' => false))                
            ->add('apellido2', TextType::class, array('required' => false))                
            ->add('direccion', TextType::class, array('required' => false))                
            ->add('barrio', TextType::class, array('required' => false))                
            ->add('telefono', TextType::class, array('required' => false))                    
            ->add('correo', TextType::class, array('required' => false))
            ->add('cantidad', TextType::class, array('required' => false))
            ->add('peso', TextType::class, array('required' => false))
            ->add('pesoVolumen', TextType::class, array('required' => false))
            ->add('declarado', TextType::class, array('required' => false))                            
            ->add('guardar', SubmitType::class)
            ->add('guardarnuevo', SubmitType::class, array('label'  => 'Guardar y Nuevo'));        
    }
 
    public function getBlockPrefix()
    {
        return 'form';
    }
}

