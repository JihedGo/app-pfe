<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null, ['attr'=>['class'=>'form-control'],'label'=>'CIN'])
            ->add('changePassword', null, ['attr'=>['class'=>'form-control'],'label'=>'Nv Mot de passe'])
            ->add('tel', null, ['attr'=>['class'=>'form-control'],'label'=>'Tél'])
            ->add('address', TextareaType::class, ['attr'=>['class'=>'form-control'],'label'=>'Adresse'])
            ->add('firstName', TextType::class, ['attr'=>['class'=>'form-control'],'label'=>'Prénom'])
            ->add('lastName', TextType::class, ['attr'=>['class'=>'form-control'],'label'=>'Nom'])
            ->add('gender', 
                    ChoiceType::class, 
                    [   
                        'attr'=>['class'=>'form-control'],
                        'choices'=>[
                            'Masculin'=>'masculin',
                            'Feminin' => 'feminin'
                            ]
                    ]
                )
            ->add('emailAddress', EmailType::class, ['attr'=>['class'=>'form-control'],'label'=>'Mot de passe'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
