<?php

namespace App\Form;


use App\Entity\Lieu;
use App\Entity\Sortie;

use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;


class LieuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nom', TextType::class, [
            'label' => 'Nom du lieu :',
            'required' => true,
            'trim' => true,
        ]);
        $builder->add('rue', TextType::class,[
            'label' => 'Rue :',
            'required' => false,
            'trim' => true,
        ]);
        $builder->add('latitude',  NumberType::class,[
            'label' => 'Latitude (optionnel):',
            'trim' => true,
            'required' => false,
            'invalid_message' => "Valeur incorrecte ",
        ]);
        $builder->add('longitude',  NumberType::class,[
            'label' => 'Longitude (optionnel):',
            'trim' => true,
            'required' => false,
            'invalid_message' => "Valeur incorrecte ",
        ]);

        $builder->add('ville',  EntityType::class, [
            'choice_label'=> "nom",
            'placeholder'=>"Choisissez une ville",
            'class' => Ville::class,
            'label' => 'Ville :',
            'required' => true,
        ]);

        $builder ->add ('submit', SubmitType::class, [
            'label' => 'Valider',

        ]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }

    //Doc de Symfony
    //Pour le formulaire de modification, il faudra regarder les formEvent
    //postSetData permet de faire des modifications après chargement de la page
    //Permet de dire quelle ville doit être sélectionnée dans la liste de villes
    

}
