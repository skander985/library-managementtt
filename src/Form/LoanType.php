<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Loan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrowedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('returnedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('borrower', EntityType::class, [
                'class' => Borrower::class,
                'choice_label' => 'id',
            ])
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
