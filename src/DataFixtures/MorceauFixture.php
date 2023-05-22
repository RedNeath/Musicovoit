<?php


namespace App\DataFixtures;


use App\Entity\Morceau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MorceauFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $morceau = new Morceau();
        $morceau->setNom("The Quest and The Curse")
            ->setArtiste("Delain");
        $manager->persist($morceau);

        $manager->flush();
    }
}