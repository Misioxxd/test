<?php
/**
 * Created by PhpStorm.
 * User: gm
 * Date: 06.03.17
 * Time: 16:07
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RelationType extends AbstractType
{
 public function buildForm(FormBuilderInterface $builder, array $options)
 {
    $builder->add('name',TextType::class)
        ->add('surname',TextType::class)
        ->add('work',TextType::class)
        ->add('save',SubmitType::class);
 }
}