<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * UserInfoFormType constructor.
     * @param TranslatorInterface $translator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager)
    {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
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
                'required' => false,
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
                'required' => false,
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
                    ]),
                    new Callback([
                        'callback' => [$this, 'validationEmailUniqueness']
                    ])
                ]
            ])
            ->add('userSchoolInfos', CollectionType::class, [
                'entry_type' => UserSchoolInfoFormType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'constraints' => new Valid()
            ])

            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('user_info_form.form_label.submit'),
            ])
        ;
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validationEmailUniqueness($value, ExecutionContextInterface $context)
    {
        $isUniqueEmail =  $this->entityManager
            ->getRepository(User::class)
            ->isUniqueEmail($value);

        if (!$isUniqueEmail) {
            $context
                ->buildViolation(
                    $this->translator->trans('user_info_form.validation.email_not_unique')
                )
                ->atPath(
                    $context->getPropertyPath()
                )
                ->addViolation();
        }
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
        return __CLASS__;
    }
}