<?php

namespace App\Form;

use App\Entity\UserSchoolInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'label' => $this->translator->trans('user_school_info_form.form_label.faculty'),
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 255
                    ]),
                ]
            ])
            ->add('degree', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.degree')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.degree'),
                'choices' => [
                    $this->translator->trans('user_school_info_form.choices.first_degree') => 1,
                    $this->translator->trans('user_school_info_form.choices.second_degree') => 2,
                ],
                'constraints' => [
                    new NotBlank(),
                    new Choice([1, 2]),

                ]
            ])
            ->add('year', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.year')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.year'),
                'choices' => [
                    $this->translator->trans('user_school_info_form.choices.first_year') => 1,
                    $this->translator->trans('user_school_info_form.choices.second_year') => 2,
                    $this->translator->trans('user_school_info_form.choices.third_year') => 3,
                    $this->translator->trans('user_school_info_form.choices.fourth_year') => 4,
                ],
                'constraints' => [
                    new NotBlank(),
                    new Choice([1, 2, 3, 4])
                ]
            ])
            ->add('group', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.group')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.group'),
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 255
                    ]),
                ]
            ])
            ->add('subgroup', ChoiceType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.subgroup')
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.subgroup'),
                'choices' => [
                    $this->translator->trans('user_school_info_form.choices.first_subgroup') => 1,
                    $this->translator->trans('user_school_info_form.choices.second_subgroup') => 2,
                ],
                'constraints' => [
                    new NotBlank(),
                    new Choice([1, 2])
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