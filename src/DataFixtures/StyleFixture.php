<?php// TODO: Implement load() method.


namespace App\DataFixtures;


use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StyleFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $style = new Style();
        $style->setNom("Métal symphonique");
        $manager->persist($style);

        $manager->flush();
    }
}