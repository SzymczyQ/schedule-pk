<?php

namespace App\Form;

use App\Entity\UserSchoolInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class UserSchoolInfoFormType
 * @package App\Form
 */
class UserSchoolInfoFormType extends AbstractType
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * UserSchoolInfoFormType constructor.
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
            ->add('faculty', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.faculty')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.faculty')
            ])
            ->add('degree', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.degree')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.degree'),
                'choices' => [
                    1 => $this->translator->trans('user_school_info_form.choices.first_degree'),
                    2 => $this->translator->trans('user_school_info_form.choices.second_degree'),
                ]
            ])
            ->add('year', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.year')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.year'),
                'choices' => [
                    1 => $this->translator->trans('user_school_info_form.choices.first_year'),
                    2 => $this->translator->trans('user_school_info_form.choices.second_year'),
                    3 => $this->translator->trans('user_school_info_form.choices.third_year'),
                    4 => $this->translator->trans('user_school_info_form.choices.fourth_year'),
                ]
            ])
            ->add('group', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.group')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.group')
            ])
            ->add('subgroup', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.subgroup')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.subgroup'),
                'choices' => [
                    1 => $this->translator->trans('user_school_info_form.choices.first_subgroup'),
                    2 => $this->translator->trans('user_school_info_form.choices.second_subgroup'),
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSchoolInfo::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return UserSchoolInfoFormType::class;
    }
}