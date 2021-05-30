<?php

namespace App\Form;

use App\Entity\Postule;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PostuleType extends AbstractType
{
    private $classRoom;
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->classRoom  = $security->getUser()->getClasse();
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('binome',EntityType::class,[
                'class'=>User::class,
                'query_builder' => function (EntityRepository $er) {
                       return $er->createQueryBuilder('u')
                                 ->select('u')
                                 ->where('u.role = :r')
                                 ->setParameter('r','ROLE_STUDENT');
                },
                'placeholder' => 'Séléctionner votre binome',
                'label'=>"Votre binome",
                'required' => false,
                'attr' => ['class'=>'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Postule::class,
        ]);
    }
}
