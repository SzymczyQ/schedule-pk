<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserInfoFormType
 * @package App\Form
 */
class UserInfoFormType extends AbstractType
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * UserInfoFormType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_info_form.form_placeholder.first_name')
                ],
                'label' => $this->translator->trans('user_info_form.form_label.first_name'),
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 180
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_info_form.form_placeholder.last_name')
                ],
                'label' => $this->translator->trans('user_info_form.form_label.last_name'),
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 180
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_info_form.form_placeholder.email')
                ],
                'label' => $this->translator->trans('user_info_form.form_label.email'),
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length([
                        'min' => 3,
                        'max' => 35,
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('user_info_form.form_label.submit'),
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return UserInfoFormType::class;
    }
}