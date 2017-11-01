<?php
namespace OrderEntry\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => '名前',
                'required' => true,
            ))
            ->add('kana', TextType::class, array(
                'label'=> 'カナ',
                'required' => true
            ))
            ->add('position', TextType::class, array(
                'label' => '役職',
            ));
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'order_entry_user_registration';
    }
}