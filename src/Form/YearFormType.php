<?php

namespace App\Form;

use App\Entity\Cycle;
use App\Entity\Faculty;
use App\Entity\Year;
use App\Repository\CycleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class YearFormType
 * @package App\Form
 */
class YearFormType extends AbstractType
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * YearFormType constructor.
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
                    'placeholder' => $this->translator->trans('year_form.form_placeholder.name')
                ],
                'label' => $this->translator->trans('year_form.form_label.name'),
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Length([
                        'min' => 3,
                        'max' => 50
                    ])
                ]
            ])
            ->add('cycle', EntityType::class, [
                'attr' => [
                    'placeholder' => $this->translator->trans('year_form.form_placeholder.cycle')
                ],
                'label' => $this->translator->trans('year_form.form_label.cycle'),
                'required' => true,
                'class' => Cycle::class,
                'choice_label' => 'name',
                'query_builder' => function (CycleRepository $cycleRepository) {
                    return $cycleRepository->createQueryBuilder('f')
                        ->orderBy('f.name', 'ASC');
                },
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('year_form.form_label.submit'),
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Year::class,
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