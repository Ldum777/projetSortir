<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileFormType extends AbstractType
{
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
        $builder->add('pseudo', TextType::class, [
            'label'=> 'Pseudo',
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
        $builder->add('plainPassword', PasswordType::class, [
            'label'=> 'Mot de passe',
            'trim'=> true,
            'required' => false,

        ]);

        $builder->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
