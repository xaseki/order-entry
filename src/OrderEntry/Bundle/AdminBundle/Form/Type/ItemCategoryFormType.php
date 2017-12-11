<?php
namespace OrderEntry\Bundle\AdminBundle\Form\Type;

use OrderEntry\Bundle\AppBundle\Entity\ItemCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemCategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'カテゴリー名',
                'required' => true,
            ))
            ->add('slug', TextType::class,array(
                'label' => 'スラッグ',
                'required' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ItemCategory::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'order_entry_item_category';
    }

}