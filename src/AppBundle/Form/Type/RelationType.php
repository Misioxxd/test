<?php
/**
 * Created by PhpStorm.
 * User: gm
 * Date: 06.03.17
 * Time: 16:07
 */

namespace AppBundle\Form\Type;


use AppBundle\Repository\WorkEntityMenager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationType extends AbstractType
{

 public function buildForm(FormBuilderInterface $builder, array $options)
 {


     $builder->add('name',TextType::class, array(
         'label'=>"imie"
     ))
        ->add('surname',TextType::class, array(
            'label'=>"nazwisko"
        ))
         ->add('work', EntityType::class, array(
                 'class' => 'AppBundle:Work',
                 'multiple' => false,
                 'choice_label'=>'name',
                 'label'=>'Praca'
            )
        );

 }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>'AppBundle\Entity\Test'
        ]);
    }
}