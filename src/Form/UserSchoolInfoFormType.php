<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserSchoolInfo;
use App\Repository\GroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
            ->add('group', EntityType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.group'),
                    'class' => 'user-school-info-group'
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.group'),
                'required' => true,
                'class' => Group::class,
                'choice_label' => 'name',
                'query_builder' => function (GroupRepository $groupRepository) {
                    return $groupRepository->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Callback([
                        'callback' => [$this, 'checkGroupUniqueness']
                    ])
                ]
            ])
            ->add('year', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.year'),
                    'class' => 'user-school-info-year'
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.year'),
                'disabled' => true,
                'mapped' => false
            ])
            ->add('cycle', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.cycle'),
                    'class' => 'user-school-info-cycle'
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.cycle'),
                'disabled' => true,
                'mapped' => false
            ])
            ->add('faculty', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('user_school_info_form.form_placeholder.faculty'),
                    'class' => 'user-school-info-faculty'
                ],
                'label' => $this->translator->trans('user_school_info_form.form_label.faculty'),
                'disabled' => true,
                'mapped' => false
            ])
        ;
    }

    /**
     * @param $group
     * @param ExecutionContextInterface $context
     */
    public function checkGroupUniqueness($group, ExecutionContextInterface $context): void
    {
        /** @var User $user */
        $user = $context->getRoot()->getData();
        $currentGroupName = $group instanceof Group ? $group->getName() : null;
        $groupCount = 0;

        /** @var UserSchoolInfo $userSchoolInfo */
        foreach ($user->getUserSchoolInfos() as $userSchoolInfo) {
            $group = $userSchoolInfo->getGroup();
            if ($group->getName() === $currentGroupName) {
                $groupCount++;
            }
        }

        if ($groupCount > 1) {
            $context
                ->buildViolation(
                    $this->translator->trans('user_school_info_form.validation.group_not_unique')
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
            'data_class' => UserSchoolInfo::class,
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