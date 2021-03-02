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


class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nom', TextType::class, [
            'label' => 'Intitulé de la sortie :',
            'required' => true,
            'trim' => true,
        ]);
        $builder->add('dateHeureDebut', DateTimeType::class,[
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'label' => 'Date et heure de début :',
            'required' => true,
        ]);
        $builder->add('duree',  NumberType::class,[
            'label' => 'Durée de la sortie (en min) :',
            'trim' => true,
            'required' => true,
            'invalid_message' => "Valeur incorrecte ",
        ]);
        $builder->add('dateLimiteInscription', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date limite d\'inscription :',
            'required' => true,
            'trim' => true,
        ]);
        $builder->add('nbInscriptionsMax', NumberType::class, [
            'label' => 'Nombre maximum de participants (organisateur compris) :',
            'trim' => true,
            'required' => true,
            'invalid_message' => "Valeur incorrecte ",
        ]);
        $builder->add('infosSortie', TextareaType::class, [
            'label' => 'Infos sur la sortie :',
            'required' => false,
            'trim' => true,
        ]);

        $builder->add('ville',  EntityType::class, [
            'choice_label'=> "nom",
            'placeholder'=>"Choisissez une ville",
            'class' => Ville::class,
            'label' => 'Ville :',
            'required' => true,
            'mapped'=> false //Ne pas mapper une ville à une Sortie
        ]);

        $builder->add('lieu',  EntityType::class, [
            'choice_label'=> "nom",
            'placeholder'=>"Choisissez un lieu",
            'class' => Lieu::class,
            'label' => 'Lieu:',
            'required' => true,
            'trim' => true,
        ]);


        $builder ->add ('submit', SubmitType::class, [
            'label' => 'Valider',

        ]);
        $builder ->add ('enregistrer', SubmitType::class, [
            'label' => 'Enregistrer',

        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

    //Doc de Symfony
    //Pour le formulaire de modification, il faudra regarder les formEvent
    //postSetData permet de faire des modifications après chargement de la page
    //Permet de dire quelle ville doit être sélectionnée dans la liste de villes
    

}
