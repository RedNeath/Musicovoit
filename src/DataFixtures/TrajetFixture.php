<?php


namespace App\DataFixtures;


use App\Entity\Trajet;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrajetFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $trajet = new Trajet();
        $trajet->setDepart($manager->merge($this->getReference('nantes')))
            ->setArrivee($manager->merge($this->getReference('montaigu')))
            ->setDate(new DateTime())
            ->setConducteur($manager->merge($this->getReference('cedric')))
            ->setVehicule($manager->merge($this->getReference('cedric-vw-golf')))
            ->setPlaces(2)
            ->setPrix("5,00");
        $manager->persist($trajet);

        $manager->flush();
    }
}