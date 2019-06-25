<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('file', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'empty_data' => $builder->getForm()->getData('event')->getFileName(),
                //  'download_uri' => '...',
                'download_label' => 'download_file',
            ])
            ->add('start_date', DateTimeType::class, [
                "date_widget" => "single_text",
                "time_widget" => "single_text"
            ])
            ->add('end_date', DateTimeType::class, [
                "date_widget" => "single_text",
                "time_widget" => "single_text"
            ])
            ->add('location_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
