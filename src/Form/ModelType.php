<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label'=> 'model.form.name.label',
                'attr'=>[
                    'placeholder'=>'model.form.name.placeholder',
                ]
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'label' => 'model.form.brand.label',
                'choice_label'=> 'name',
                'query_builder'=> function (EntityRepository $er){
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC')
                        ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
