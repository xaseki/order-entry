<?php

namespace OrderEntry\Bundle\AdminBundle\Form\Type;

use OrderEntry\Bundle\AdminBundle\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use  Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminLoginFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('username', TextType::class, array(
                    'label' => 'ユーザー名',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'ユーザー名',
                        'id'=>'username',
                    )
                )
           )
                ->add('password', PasswordType::class, array(
                    'label' => 'パスワード',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'パスワード',
                        'id'=>'password',
                    )
                )
            )    
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults(array(
            'csrf_token_id' => 'authenticate',
            'data_class' => Admin::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'order_entry_admin_login';
    }
}
