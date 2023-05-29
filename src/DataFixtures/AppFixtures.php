<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use App\Entity\Message;
use App\Entity\Avis;
use App\Entity\Vehicule;
use App\Entity\Ville;
use DateTime;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        generateFakeUt($manager);
        entrer($manager);

        $manager->flush();
    }
    public function entrer(ObjectManager $manager)
    {
        $util=generateFakeUtilisateur($manager);
        generateFakeTrajets($manager,$util);
        generateFakeAvis($manager,50);
        generateFakeMessages($manager,50);
    }
    public function generateFakeUt(ObjectManager $manager)
    {
        $faker = Factory::create();
        $utilisateur=Array();

        for ($i = 0; $i < 50; $i++) {
            $utilisateur[$i] = new Utilisateur();
            $utilisateur[$i]->setNom($faker->lastName);
            $utilisateur[$i]->setPrenom($faker->firstName);
            $utilisateur[$i]->setVehicule(generateFakeVehicule($manager));            
            $manager->persist($utilisateur[$i]);
            echo 'ajout';
        }

        $manager->flush();
    }
    public function generateFakeUtilisateur(ObjectManager $manager)
    {
        $faker = Factory::create();
        $utilisateur=Array();

        for ($i = 0; $i < 50; $i++) {
            $utilisateur[$i] = new Utilisateur();
            $utilisateur[$i]->setNom($faker->lastName);
            $utilisateur[$i]->setPrenom($faker->firstName);
            $utilisateur[$i]->setVehicule(generateFakeVehicule($manager));            
            $manager->persist($utilisateur[$i]);
        }

        $manager->flush();
        return $utilisateur;
        }
        public function generateFakeTrajets(ObjectManager $manager, array $utilisateurs)
        {
            $faker = Factory::create();
            $trajets = [];

            for ($i = 0; $i < 20; $i++) {
                $trajet = new Trajet();
                $trajet->setDate($faker->dateTimeBetween('-1 month', '+1 month'));
                $trajet->setPrix($faker->randomFloat(2, 10, 100));
                $passagersCount = $faker->numberBetween(1, 5);
                $trajet->setPlaces($passagersCount);
                $trajet->setConducteur($faker->randomElement($utilisateurs));
                $trajet->setVehicule($trajet->getConducteur()->getVehicule());
                // Définissez les autres propriétés de Trajet en fonction de votre implémentation

                // Ajout de passagers aléatoires
                for ($j = 0; $j < $passagersCount; $j++) {
                    //$passager = $faker->name;
                    $trajet->addPassager($faker->randomElement($utilisateurs));
                }
                
                $trajet->addAvis();
                $trajet->addMessage();
                $manager->persist($trajet);
                $trajets[] = $trajet;
            }

            $manager->flush();
            return $trajets;
        }
        public function generateFakeMessages(ObjectManager $manager, int $count = 50)
        {
            $faker = Factory::create();

            // Récupérez tous les trajets disponibles pour créer des relations
            $trajets = $manager->getRepository(Trajet::class)->findAll();

            for ($i = 0; $i < $count; $i++) {
                $message = new Message();
                $message->setDate($faker->dateTimeBetween('-1 month', 'now'));
                $message->setTexte($faker->sentence);

                // Sélectionnez un trajet aléatoire pour établir la relation
                $trajet = $faker->randomElement($trajets);

                $message->setTrajet($trajet);

                $manager->persist($message);
            }

            $manager->flush();
        }
        public function addRandomConducteursToVehicule(ObjectManager $manager, Vehicule $vehicule)
        {
            $faker = Factory::create();
            $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();

            $randomConducteurs = $faker->randomElements($utilisateurs);
            $vehicule->setConducteurs($randomConducteurs);

            $manager->persist($vehicule);
            $manager->flush();
        }

        
        public function generateFakeAvis(ObjectManager $manager, int $count = 50)
    {
        $faker = Factory::create();

        // Récupérez tous les trajets et utilisateurs disponibles pour créer des relations
        $trajets = $manager->getRepository(Trajet::class)->findAll();
        $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();

        for ($i = 0; $i < $count; $i++) {
            $avis = new Avis();
            $avis->setDate($faker->dateTimeBetween('-1 year', 'now'));
            $avis->setTexte($faker->sentence);
            $avis->setNote($faker->numberBetween(1, 5));

            // Sélectionnez un trajet et un utilisateur aléatoires pour établir les relations
            $trajet = $faker->randomElement($trajets);
            $utilisateur = $faker->randomElement($utilisateurs);

            $avis->setTrajet($trajet);
            $avis->setUtilisateur($utilisateur);

            $manager->persist($avis);
        }

    $manager->flush();
}
    public function generateFakeVehicule(ObjectManager $manager)
    {

        $faker = Factory::create();

        $marques = [
            'Toyota', 'Ford', 'Chevrolet', 'Honda', 'Volkswagen', 'Nissan', 'Mercedes-Benz', 'BMW', 'Audi', 'Hyundai',
            'Kia', 'Mazda', 'Volvo', 'Subaru', 'Lexus', 'Jeep', 'Land Rover', 'Tesla', 'Ferrari', 'Porsche',
            'Mitsubishi', 'Peugeot', 'Renault', 'Jaguar', 'Chrysler', 'Dodge', 'Acura', 'Infiniti', 'Cadillac', 'Buick',
            'GMC', 'Lamborghini', 'Maserati', 'Alfa Romeo', 'MINI', 'Bentley', 'Rolls-Royce', 'Lotus', 'Fiat', 'Suzuki',
            'Smart', 'Hummer', 'Lincoln', 'Maybach', 'McLaren', 'Aston Martin', 'Bugatti', 'Koenigsegg', 'Pagani', 'Zenvo'
        ];
        
        $modeles = [
            'Camry', 'F-150', 'Cruze', 'Civic', 'Golf', 'Altima', 'E-Class', '3 Series', 'A4', 'Elantra',
            'Optima', 'CX-5', 'XC90', 'Outback', 'IS', 'Wrangler', 'Range Rover', 'Model S', '488 GTB', '911',
            'Lancer', '308', 'Clio', 'XE', '300', 'Challenger', 'TLX', 'Q50', 'Escalade', 'Enclave',
            'Sierra', 'Huracán', 'GranTurismo', 'Giulia', 'Countryman', 'Continental', 'Phantom', 'Evora', '500', 'Swift',
            'Fortwo', 'H2', 'Navigator', 'S-Class', '720S', 'Vantage', 'Chiron', 'Regera', 'Huayra', 'TS1'
        ];
        $couleurs = ['Rouge', 'Bleu', 'Noir', 'Blanc', 'Gris','Jaune','Vert'];

            $vehicules = new Vehicule();
            $vehicules->setMarque($faker->randomElement($marques));
            $vehicules->setModele($faker->randomElement($modeles));
            $vehicules->setCouleur($faker->randomElement($couleurs));

            /*$conducteurs = new ArrayCollection();
            $numConducteurs = $faker->numberBetween(1, 5);

            
            for ($j = 0; $j < $numConducteurs; $j++) {
                $utilisateur = new Utilisateur();
                // Définir les propriétés de l'utilisateur avec Faker si nécessaire
                // ...
                $conducteurs->add($utilisateur);
            }

            $vehicules[$i]->setConducteurs($conducteurs);
            */
            $manager->persist($vehicules);
        
        $manager->flush();
    }

}

