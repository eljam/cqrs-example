<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Presentation\Web\Frontoffice\Form;

use App\Application\Command\CreateRoomTripItem\CreateRoomTripItemCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FlightTripItemFormType.
 */
final class RoomTripItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('cost', IntegerType::class)
            ->add('adults', IntegerType::class)
            ->add('children', IntegerType::class)
            ->add('paxList', TextType::class)
            ->add('tripId', TextType::class)
            ->add('accommodationId', TextType::class)
            ->add('save', SubmitType::class)
        ;

        $builder->get('id')
            ->addModelTransformer(new CallbackTransformer(
                function ($stringToUuid) {
                    return $stringToUuid;
                },
                function ($UuidToString) {
                    return Uuid::fromString($UuidToString);
                }
            ))
        ;

        $builder->get('tripId')
            ->addModelTransformer(new CallbackTransformer(
                function ($stringToUuid) {
                    return $stringToUuid;
                },
                function ($UuidToString) {
                    return Uuid::fromString($UuidToString);
                }
            ))
        ;

        $builder->get('accommodationId')
            ->addModelTransformer(new CallbackTransformer(
                function ($stringToUuid) {
                    return $stringToUuid;
                },
                function ($UuidToString) {
                    return Uuid::fromString($UuidToString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateRoomTripItemCommand::class,
        ]);
    }
}
