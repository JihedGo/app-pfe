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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin', TextType::class, ['label'=>"CIN",'attr'=>['class'=>'form-control']])
            ->add('tel', TextType::class, ['label'=>"Tél",'attr'=>['class'=>'form-control']])
            ->add('address', TextareaType::class, ['label'=>"Adresse",'attr'=>['class'=>'form-control']])
            ->add('grade',ChoiceType::class,[
                'choices'=>[
                    
                    'PES'=>'PES',
                    'AC'=> 'AC',
                    'MA'=>'MA',
                    'MC'=>'MC',
                    'PR'=>'PR',
                ],
                'attr'=>['class'=>"form-control"]
            ])
            ->add('firstName', TextType::class, ['label'=>"Nom",'attr'=>['class'=>'form-control']])
            ->add('lastName', TextType::class, ['label'=>"Prénom",'attr'=>['class'=>'form-control']])
            ->add('gender',ChoiceType::class,[
                'choices'=>[
                    'Feminin'=>"female",
                    'Masculin'=>"masculin"
                ],
                'attr'=>['class'=>"form-control"]
            ])
            ->add('emailAddress', EmailType::class,['label'=>"Email",'attr'=>['class'=>'form-control']])
            ->add('department',null, ['label'=>"Departement",'attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
