<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\CoordinatesType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StationType extends AbstractType {

    private $stationStatus;

    public function __construct($stationStatus) {
        $this->stationStatus = $stationStatus;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name');
        $builder->add('address');
        $builder->add('coordinates', CoordinatesType::class);
        $builder->add('bikesCapacity');
        $builder->add('bikesAvailable');
        $builder->add('status', ChoiceType::class, array(
            'choices' => $this->stationStatus
                )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Station'
        ));
    }

    public function getName() {
        return 'appbundle_stationtype';
    }

}
