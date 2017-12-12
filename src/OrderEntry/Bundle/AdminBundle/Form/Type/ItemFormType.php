<?php

namespace OrderEntry\Bundle\AdminBundle\Form\Type;

use OrderEntry\Bundle\AppBundle\Entity\Item;
use OrderEntry\Bundle\AppBundle\Entity\ItemCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => '名前',
                'label_attr' => array(
                    'class' => 'form-label'
                ),
                'required' => true,
            ))
            ->add('price', MoneyType::class, array(
                'label'=> '価格',
                'label_attr' => array(
                    'class' => 'form-label'
                ),
                'required' => true,
                'currency' => false,
            ))
            ->add('category', null, array(
                'label' => 'カテゴリー',
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'order_entry_item';
    }

}