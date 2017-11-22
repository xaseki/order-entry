<?php
namespace OrderEntry\Bundle\UserBundle\Form\Type;

use OrderEntry\Bundle\AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'csrf_token_id' => 'registration',
            'intention'  => 'registration',
            'attr'=>array('novalidate'=>'novalidate'),
        ));
    }
    

    public function getBlockPrefix()
    {
        return 'order_entry_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}