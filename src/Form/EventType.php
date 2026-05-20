<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Event Title',
                'attr' => ['placeholder' => 'e.g. Open AA Meeting — Downtown Madison'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows' => 4, 'placeholder' => 'Details about the event...'],
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Start Date & Time',
                'widget' => 'single_text',
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'End Date & Time (optional)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'label' => 'Venue / Location Name',
                'required' => false,
                'attr' => ['placeholder' => 'e.g. Madison Senior Center'],
            ])
            ->add('address', TextType::class, [
                'label' => 'Street Address',
                'required' => false,
                'attr' => ['placeholder' => '330 W. Mifflin St.'],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => false,
                'attr' => ['placeholder' => 'Madison'],
            ])
            ->add('state', TextType::class, [
                'label' => 'State',
                'required' => false,
                'attr' => ['placeholder' => 'WI', 'maxlength' => 2],
            ])
            ->add('zip', TextType::class, [
                'label' => 'ZIP Code',
                'required' => false,
                'attr' => ['placeholder' => '53703'],
            ])
            ->add('zoomLink', UrlType::class, [
                'label' => 'Zoom / Meeting Link (optional)',
                'required' => false,
                'attr' => ['placeholder' => 'https://zoom.us/j/...'],
            ])
            ->add('flyerFile', FileType::class, [
                'label' => 'Event Flyer (PDF only)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Please upload a valid PDF file.',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'I confirm this is an AA event in accordance with the Twelve Traditions.',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Event::class]);
    }
}
