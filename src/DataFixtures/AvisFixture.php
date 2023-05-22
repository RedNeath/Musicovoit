<?php


namespace App\DataFixtures;


use App\Entity\Avis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \DateTime;

class AvisFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $avis = new Avis();
        $avis->setDate(new DateTime())
            ->setNote(5)
            ->setTexte("Très bon conducteur")
            ->setUtilisateur($manager->merge($this->getReference('marie')))
            ->setTrajet($manager->merge($this->getReference('cedric-nantes-montaigu')));
        $manager->persist($avis);

        $manager->flush();
    }
}