<?php

namespace App\Form;


use App\Service\JokeFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class JokeType extends AbstractType
{
    private $jokeFetcher;

    /**
     * JokeType constructor.
     * @param $jokeFetcher
     */
    public function __construct(JokeFetcher $jokeFetcher)
    {
        $this->jokeFetcher = $jokeFetcher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('category', ChoiceType::class, [
                'choices' => $this->jokeFetcher->getCategories(),
                'choice_label' => function ($choice, $key, $value) {
                    return strtoupper($value);
                },
            ])
            ->add('get joke', SubmitType::class)
        ;
    }
}