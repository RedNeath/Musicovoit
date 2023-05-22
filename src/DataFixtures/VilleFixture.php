<?php


namespace App\DataFixtures;


use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $ville = new Ville();
        $ville->setNom("Nantes")
            ->setCodePostal("44000");
        $manager->persist($ville);

        $ville1 = new Ville();
        $ville1->setNom("Montaigu")
            ->setCodePostal("85600");
        $manager->persist($ville1);

        $manager->flush();
    }
}