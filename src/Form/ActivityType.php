<?php

namespace App\Form;

use App\Entity\Activity;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('file', VichImageType::class/*, [
                'required' => false,
                'allow_delete' => true,
                'empty_data' => $builder->getForm()->getData('activity')->getFileName(),
                //  'download_uri' => '...',
                'download_label' => 'download_file',
            ]*/)
            ->add('max_people')
            ->add('description', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
