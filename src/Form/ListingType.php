<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'required' => true,
                'label' => 'listing.form.title.label',
                'attr' => [
                    'placeholder' => 'listing.form.title.placeholder'
                ]
            ])
            ->add('description', null, [
                'required' => true,
                'label' => 'listing.form.description.label',
                'attr' => [
                    'placeholder' => 'listing.form.description.placeholder',
                    'rows'=> 8
                ]
            ])
            ->add('producedYear', null, [
                'required' => true,
                'label' => 'listing.form.producedYear.label',
            ])
            ->add('mileage', null, [
                'required' => true,
                'label' => 'listing.form.mileage.label',
                'attr' => [
                    'placeholder' => 'listing.form.mileage.placeholder'
                ]
            ])
            ->add('price', null, [
                'required' => true,
                'label' => 'listing.form.price.label',
                'attr' => [
                    'placeholder' => 'listing.form.price.placeholder'
                ]
            ])
            ->add('image', FileType::class,[
                'required'=> false,
                'constraints' => [
                    new File(
                        mimeTypes: ['image/apng', 'image/jpeg'],
                        mimeTypesMessage: 'Déposer seulement un .jpg ou .png'
                    )
                ]
            ])
            ->add('model', EntityType::class, [
                'class'=> Model::class,
                'label' => 'listing.form.model.label',
                'choice_label'=> 'fullName',
                'query_builder'=> function (EntityRepository $er){
                return $er->createQueryBuilder('m')
                    ->join('m.brand', 'b')
                    ->orderBy('b.id')
                    ->addOrderBy('m.name', 'ASC')
                    ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
