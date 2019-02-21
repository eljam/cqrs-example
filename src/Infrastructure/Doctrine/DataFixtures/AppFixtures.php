<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\Model\Accommodation;
use App\Domain\Model\AccommodationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class AppFixtures.
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $body = <<<EOF
Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. 
Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla 
ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. 
Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu 
n'en soit modifié. 
Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, 
et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.
EOF;

        $hotelAccommodationType  = new AccommodationType(Uuid::uuid4(), 'Hotel');
        $airbnbAccommodationType = new AccommodationType(Uuid::uuid4(), 'Airbnb');

        $accommodation = new Accommodation(
            Uuid::uuid4(),
            'Hotel cqrs',
            \substr($body, 0, 100),
            $body,
            \mt_rand(0, 5),
            '38 rue du faubourg du temple',
            '+33145875621'
        );
        $accommodation->addAccommodationType($hotelAccommodationType);

        $manager->persist($airbnbAccommodationType);
        $manager->persist($hotelAccommodationType);
        $manager->persist($accommodation);

        $manager->flush();
    }
}
