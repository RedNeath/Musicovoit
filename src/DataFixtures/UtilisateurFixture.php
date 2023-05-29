<?php


namespace App\DataFixtures;


use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixture extends Fixture
{
    
    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager):void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom("self")
            ->setPrenom("self")
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($utilisateur);

        $utilisateur1 = new Utilisateur();
        $utilisateur1->setNom("a")
            ->setPrenom("Cédric")
            ->setVehicule($manager->merge($this->getReference("cedric-vw-golf")))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setNom("b")
            ->setPrenom("Marie")
            ->setRoles(["ROLE_USER"]);
        $manager->persist($utilisateur2);

        $manager->flush();
    }

    
}