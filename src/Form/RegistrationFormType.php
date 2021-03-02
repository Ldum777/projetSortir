<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormTypeInterface;

class RegistrationFormType extends AbstractType
{
    /* public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        $builder->add('prenom', TextType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        $builder->add('pseudo', TextType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        $builder->add('telephone', TextType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        //A retravailler avec une liste de sites.
        $builder->add('siteRattachement', EntityType::class, [
            'class'=> Site::class,
            'choice_label' => 'nom',
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        $builder->add('email', EmailType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);

        $builder->add('plainPassword', PasswordType::class, [
            'trim'=> true,
            'required' => true,
            'attr' => [
                'class'=> 'form-control'
            ]
        ]);
//        $builder->add('admin', IntegerType::class, [
//            'label'=> 'Admin',
//            'trim'=> true,
//            'required' => false,
//
//        ]);
//        $builder->add('actif', IntegerType::class, [
//            'label'=> 'actif',
//            'trim'=> true,
//            'required' => false,
//
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
