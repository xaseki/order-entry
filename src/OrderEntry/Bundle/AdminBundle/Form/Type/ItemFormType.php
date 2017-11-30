<?php
namespace OrderEntry\Bundle\AdminBundle\Form\Type;

use OrderEntry\Bundle\AppBundle\Entity\Item;
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
                'required' => true,
            ))
            ->add('price', MoneyType::class, array(
                'label'=> '価格',
                'required' => true
            ))
            ->add('catefoies', null, array(
                'label' => 'カテゴリー',
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Item::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'order_entry_item';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}