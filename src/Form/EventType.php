<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => false])
            ->add('file', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'empty_data' => $builder->getForm()->getData('event')->getFileName(),
                //  'download_uri' => '...',
                'download_label' => 'download_file',
            ])
            ->add('start_date', DateType::class, ['label' => false, 'widget' => 'single_text', 'attr' => ['class' => 'js-datepicker form', 'min' => date('Y-m-d')]])
            ->add('end_date', DateType::class, ['label' => false, 'widget' => 'single_text', 'attr' => ['class' => 'js-datepicker form', 'min' => date('Y-m-d')]])
            ->add('location_id', null, ['label' => false])
            ->add('description', TextAreaType::class, ['label' => false])
            ->add('save', SubmitType::class, ['label' => 'Opslaan'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
