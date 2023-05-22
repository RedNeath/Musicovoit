<?php


namespace App\DataFixtures;


use App\Entity\Message;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MessageFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $msg = new Message();
        $msg->setDate(new DateTime())
            ->setTexte("Merci d'avoir accepté ma demande. A demain")
            ->setUtilisateur($manager->merge($this->getReference('self')))
            ->setTrajet($manager->merge($this->getReference('cedric-nantes-montaigu')));
        $manager->persist($msg);

        $msg1 = new Message();
        $msg1->setDate(new DateTime())
            ->setTexte("Pas de quoi !\nA demain.")
            ->setUtilisateur($manager->merge($this->getReference('cedric')))
            ->setTrajet($manager->merge($this->getReference('cedric-,nantes-montaigu')));

        $msg2 = new Message();
        $msg2->setDate(new DateTime())
            ->setTexte("Bonjour, est-il possible de décaler légèrement l'heure de passage ?\n5 minutes feront l'affaire, merci d'avance.")
            ->setUtilisateur($manager->merge($this->getReference('marie')))
            ->setTrajet($manager->merge($this->getReference('cedric-nantes-montaigu')));

        $manager->flush();
    }
}