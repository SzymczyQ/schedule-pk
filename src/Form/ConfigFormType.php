<?php

namespace App\Form;

use App\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class ConfigFormType
 * @package App\Form
 */
class ConfigFormType extends AbstractType
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
            ->add('token', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('config_form.form_placeholder.token')
                ],
                'label' => $this->translator->trans('config_form.form_label.token'),
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 255
                    ])
                ]
            ])
            ->add('value', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('config_form.form_placeholder.value')
                ],
                'label' => $this->translator->trans('config_form.form_label.value'),
                'required' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('config_form.form_label.submit'),
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return __CLASS__;
    }
}