<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\CoordinatesType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CityType extends AbstractType {

    private $cityStatus;

    public function __construct($cityStatus) {
        $this->cityStatus = $cityStatus;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name');
        $builder->add('coordinates', CoordinatesType::class);
        $builder->add('status', ChoiceType::class, array(
            'choices' => $this->cityStatus
                )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\City'
        ));
    }

    public function getName() {
        return 'appbundle_citytype';
    }

}
