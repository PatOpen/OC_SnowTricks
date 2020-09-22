<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('altImage', TextType::class, [
            	'label' => 'Titre de l\'mage',
	            'required'=> false
            ])
            ->add('image', FileType::class, [
	            'label' => false,
	            'mapped' => false,
	            'required' => false,
	            'constraints' => [
		            new File([
			            'maxSize' => '2048k',
			            'mimeTypes' => [
				            'image/jpeg',
				            'image/png',
			            ],
			            'mimeTypesMessage' => 'Merci de mettre une image valide (jpeg ou png)',
		            ])
	            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
