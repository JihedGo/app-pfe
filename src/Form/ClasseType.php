<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label',TextType::class, ['label'=>'Libelle','attr'=>['class'=>"form-control"]])
            ->add('niveau', ChoiceType::class,[
                'choices'=>[
                    'Mastere Recherche' => "Mastere Recherche",
                    'Mastere Pro' => "Mastere PRO",
                    'Licence' => "Licence"
                ],
                'attr'=>['class'=>'form-control']])
            ->add('department',null,[
                'attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
