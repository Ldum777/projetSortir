<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
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
            'label'=> 'Nom',
            'trim'=> true,
            'required' => true,

        ]);
        $builder->add('prenom', TextType::class, [
            'label'=> 'Prénom',
            'trim'=> true,
            'required' => true,

        ]);
        $builder->add('telephone', TextType::class, [
            'label'=> 'telephone (optionnel)',
            'trim'=> true,
            'required' => false,

        ]);
        $builder->add('email', EmailType::class, [
            'label'=> 'Adresse Email',
            'trim'=> true,
            'required' => false,

        ]);
        $builder->add('password', PasswordType::class, [
            'label'=> 'Mot de passe',
            'trim'=> true,
            'required' => false,

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
