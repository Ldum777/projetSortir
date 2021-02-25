<?php

namespace App\Form;

use App\Entity\Site;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', EntityType::class, [
            'class'=>Site::class,
//            'placeholder'=>'Veuillez entrer un site',
            'query_builder'=>function (EntityRepository $entityRepository){
                return $entityRepository->createQueryBuilder('site')->orderBy
                ('site.id','ASC');
            },
            'choice_label' =>'nom',
            'label'=> ' ',
            'required'=> false,
            'constraints'=>[
                new NotBlank(['message'=>('Vous devez sélectionner un site.')])
            ]
        ]);
        $builder->add('submit', SubmitType::class, [
            'label'=>'Filter'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped'=>false
        ]);
    }
}
