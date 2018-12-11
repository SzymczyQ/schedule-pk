<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Year;
use App\Repository\YearRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class GroupFormType
 * @package App\Form
 */
class GroupFormType extends AbstractType
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * GroupFormType constructor.
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
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('group_form.form_placeholder.name')
                ],
                'label' => $this->translator->trans('group_form.form_label.name'),
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 50
                    ])
                ]
            ])
            ->add('year', EntityType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('group_form.form_placeholder.year')
                ],
                'label' => $this->translator->trans('group_form.form_label.year'),
                'class' => Year::class,
                'choice_label' => 'name',
                'query_builder' => function (YearRepository $yearRepository) {
                    return $yearRepository->createQueryBuilder('f')
                        ->orderBy('f.name', 'ASC');
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('group_form.form_label.submit'),
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
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