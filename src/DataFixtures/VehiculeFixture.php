<?php


namespace App\DataFixtures;


use App\Entity\Vehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehiculeFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $vehicule = new Vehicule();
        $vehicule->setMarque("Volkswagen")
            ->setModele("Golf")
            ->setCouleur("#1e40af");
        $manager->persist($vehicule);

        $manager->flush();
    }
}