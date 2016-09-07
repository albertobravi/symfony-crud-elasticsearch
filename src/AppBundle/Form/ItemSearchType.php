<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ItemSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                'required' => false,
            ))
            ->add('dateFrom', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('dateTo', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('isPublished', ChoiceType::class, array(
                'choices' => array('yes'=>'true','no'=>'false'),
                'required' => false,
            ))
            ->add('search', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
            'data_class' => 'AppBundle\Model\ItemSearch'
        ));
    }
}