<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use App\Entity\Message;
use App\Entity\Avis;
use App\Entity\Vehicule;
use DateTime;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public array $villes;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->villes = $manager->getRepository(Ville::class)->findAll();
        $this->generateFakeUt($manager);
        $this->entrer($manager);

        $manager->flush();
    }
    public function entrer(ObjectManager $manager)
    {
        $this->generateFakeVilles($manager);
        $util = $this->generateFakeUtilisateur($manager);
        $this->generateFakeTrajets($manager,$util);
        $this->generateFakeMessages($manager);
    }

    public function generateFakeVilles(ObjectManager $manager) {
        $noms = ["Toulouse", "Nice", "Nantes", "Montpellier", "Strasbourg", "Bordeaux", "Paris 15e Arrondissement", "Lille", "Rennes", "Paris 20e Arrondissement", "Paris 18e Arrondissement", "Paris 19e Arrondissement", "Reims", "Paris 13e Arrondissement", "Saint-Étienne", "Toulon", "Le Havre", "Paris 17e Arrondissement", "Paris 16e Arrondissement", "Grenoble", "Dijon", "Angers", "Nîmes", "Saint-Denis", "Villeurbanne", "Paris 11e Arrondissement", "Clermont-Ferrand", "Le Mans", "Aix-en-Provence", "Paris 12e Arrondissement", "Brest", "Paris 14e Arrondissement", "Tours", "Amiens", "Limoges", "Annecy", "Perpignan", "Boulogne-Billancourt", "Orléans", "Metz", "Besançon", "Saint-Denis", "Argenteuil", "Rouen", "Montreuil", "Mulhouse", "Caen", "Saint-Paul", "Nancy", "Lyon 3e Arrondissement", "Tourcoing", "Roubaix", "Nanterre", "Vitry-sur-Seine", "Marseille 13e Arrondissement", "Avignon", "Créteil", "Paris 10e Arrondissement", "Poitiers", "Dunkerque", "Aubervilliers", "Versailles", "Aulnay-sous-Bois", "Asnières-sur-Seine", "Colombes", "Lyon 8e Arrondissement", "Saint-Pierre", "Courbevoie", "Lyon 7e Arrondissement", "Marseille 8e Arrondissement", "Fort-de-France", "Cherbourg-en-Cotentin", "Le Tampon", "Rueil-Malmaison", "Champigny-sur-Marne", "Béziers", "Pau", "Marseille 9e Arrondissement", "Marseille 15e Arrondissement", "La Rochelle", "Saint-Maur-des-Fossés", "Calais", "Cannes", "Antibes", "Drancy", "Ajaccio", "Mérignac", "Saint-Nazaire", "Colmar", "Issy-les-Moulineaux", "Noisy-le-Grand", "Évry-Courcouronnes", "Vénissieux", "Cergy", "Bourges", "Levallois-Perret", "La Seyne-sur-Mer", "Pessac", "Valence", "Villeneuve-d'Ascq", "Quimper", "Marseille 14e Arrondissement", "Antony", "Ivry-sur-Seine", "Troyes", "Cayenne", "Clichy", "Montauban", "Marseille 12e Arrondissement", "Neuilly-sur-Seine", "Paris 9e Arrondissement", "Chambéry", "Paris 5e Arrondissement", "Niort", "Sarcelles", "Pantin", "Lorient", "Marseille 11e Arrondissement", "Le Blanc-Mesnil", "Saint-André", "Beauvais", "Marseille 10e Arrondissement", "Maisons-Alfort", "Hyères", "Épinay-sur-Seine", "Meaux", "Chelles", "Villejuif", "Narbonne", "La Roche-sur-Yon", "Cholet", "Saint-Quentin", "Bobigny", "Les Abymes", "Saint-Louis", "Bondy", "Vannes", "Clamart", "Fontenay-sous-Bois", "Fréjus", "Arles", "Sartrouville", "Lyon 6e Arrondissement", "Paris 7e Arrondissement", "Corbeil-Essonnes", "Bayonne", "Saint-Ouen-sur-Seine", "Sevran", "Cagnes-sur-Mer", "Massy", "Lyon 9e Arrondissement", "Grasse", "Montrouge", "Vincennes", "Laval", "Vaulx-en-Velin", "Lyon 5e Arrondissement", "Albi", "Marseille 3e Arrondissement", "Marseille 4e Arrondissement", "Suresnes", "Martigues", "Évreux", "Belfort", "Brive-la-Gaillarde", "Gennevilliers", "Charleville-Mézières", "Saint-Herblain", "Aubagne", "Saint-Priest", "Rosny-sous-Bois", "Marseille 5e Arrondissement", "Saint-Malo", "Blois", "Carcassonne", "Bastia", "Salon-de-Provence", "Meudon", "Choisy-le-Roi", "Chalon-sur-Saône", "Châlons-en-Champagne", "Saint-Germain-en-Laye", "Puteaux", "Livry-Gargan", "Saint-Brieuc", "Mantes-la-Jolie", "Noisy-le-Sec", "Les Sables-d'Olonne", "Alfortville", "Châteauroux", "Valenciennes", "Sète", "Caluire-et-Cuire", "Istres", "La Courneuve", "Marseille 6e Arrondissement", "Garges-lès-Gonesse", "Saint-Laurent-du-Maroni", "Talence", "Angoulême", "Castres", "Bron", "Bourg-en-Bresse", "Tarbes", "Le Cannet", "Rezé", "Paris 6e Arrondissement", "Arras", "Wattrelos", "Bagneux", "Gap", "Boulogne-sur-Mer", "Thionville", "Alès", "Compiègne", "Melun", "Le Lamentin", "Marseille 1er Arrondissement", "Douai", "Gagny", "Draguignan", "Montélimar", "Colomiers", "Anglet", "Stains", "Marcq-en-Barul", "Chartres", "Saint-Martin-d'Hères", "Joué-lès-Tours", "Saint-Benoît", "Pontault-Combault", "Saint-Joseph", "Poissy", "Châtillon", "Villefranche-sur-Saône", "Échirolles", "Villepinte", "Paris 8e Arrondissement", "Franconville", "Savigny-sur-Orge", "Sainte-Geneviève-des-Bois", "Tremblay-en-France", "Lyon 4e Arrondissement", "Conflans-Sainte-Honorine", "Annemasse", "Bagnolet", "Creil", "Montluçon", "Palaiseau", "La Ciotat", "Saint-Raphaël", "Neuilly-sur-Marne", "Saint-Chamond", "Marseille 7e Arrondissement", "Thonon-les-Bains", "Auxerre", "Haguenau", "Roanne", "Athis-Mons", "Le Port", "Paris 3e Arrondissement", "Villenave-d'Ornon", "Le Perreux-sur-Marne", "Sainte-Marie", "Mâcon", "Agen", "Saint-Leu", "Villeneuve-Saint-Georges", "Meyzieu", "Vitrolles", "Châtenay-Malabry", "Romans-sur-Isère", "La Possession", "Nevers", "Montigny-le-Bretonneux", "Marignane", "Nogent-sur-Marne", "Six-Fours-les-Plages", "Les Mureaux", "Trappes", "Cambrai", "Houilles", "Matoury", "Schiltigheim", "Châtellerault", "Épinal", "Vigneux-sur-Seine", "Plaisir", "Lens", "L' Haÿ-les-Roses", "Le Chesnay-Rocquencourt", "Saint-Médard-en-Jalles", "Viry-Châtillon", "Cachan", "Dreux", "Baie-Mahault", "Liévin", "Pontoise", "Malakoff", "Goussainville", "Lyon 2e Arrondissement", "Charenton-le-Pont", "Pierrefitte-sur-Seine", "Chatou", "Rillieux-la-Pape", "Vanduvre-lès-Nancy", "Savigny-le-Temple", "Saint-Cloud", "Périgueux", "Villemomble", "Maubeuge", "Aix-les-Bains", "Mont-de-Marsan", "Bezons", "Lyon 1er Arrondissement", "Clichy-sous-Bois", "Herblay-sur-Seine", "Vienne", "Ris-Orangis", "La Garenne-Colombes", "Ermont", "Le Plessis-Robinson", "Dieppe", "Yerres", "Thiais", "Sotteville-lès-Rouen", "Menton", "Orange", "Draveil", "Grigny", "Saint-Étienne-du-Rouvray", "Guyancourt", "Agde", "Décines-Charpieu", "Bègles", "Soissons", "Villiers-sur-Marne", "Saint-Laurent-du-Var", "Bourgoin-Jallieu", "Carpentras", "Bois-Colombes", "Paris 4e Arrondissement", "Fresnes", "Vanves", "Villiers-le-Bel", "Lambersart", "Romainville", "Bussy-Saint-Georges", "Limeil-Brévannes", "Tournefeuille", "Saint-Sébastien-sur-Loire", "Bergerac", "Montfermeil", "Le Gosier", "Illkirch-Graffenstaden", "Rambouillet", "Saumur", "Vallauris", "Sannois", "Cavaillon", "Brétigny-sur-Orge", "Sucy-en-Brie", "Miramas", "Taverny", "Orvault", "Villeparisis", "Oullins", "Lunel", "La Teste-de-Buch", "Hénin-Beaumont", "Gonesse", "Sens", "Vierzon", "Alençon", "Le Grand-Quevilly", "Kourou", "Brunoy", "Gradignan", "Aurillac", "Saintes", "Sèvremoine", "Biarritz", "Élancourt", "Montbéliard", "Le Kremlin-Bicêtre", "Les Ulis", "La Garde", "Remire-Montjoly", "Eaubonne", "Étampes", "Champs-sur-Marne", "Muret", "Béthune", "Armentières", "Laon", "Libourne", "Marseille 2e Arrondissement", "Cenon", "Fontenay-aux-Roses", "Blagnac", "Petit-Bourg", "Vertou", "Vichy", "Cormeilles-en-Parisis", "Rochefort", "Rodez", "Saint-Dizier", "Les Pavillons-sous-Bois", "La Valette-du-Var", "Vernon", "Le Bouscat", "Orly", "Montgeron", "Villeneuve-la-Garenne", "Saint-Ouen-l'Aumône", "Dole", "Sainte-Anne", "Maisons-Laffitte", "Lormont", "Sèvres", "Sainte-Suzanne", "Eysines", "Beaupréau-en-Mauges", "Les Lilas", "Roissy-en-Brie", "Grande-Synthe", "Hérouville-Saint-Clair", "Abbeville", "Frontignan", "Lanester", "Le Robert", "Épernay", "Saint-Mandé", "Torcy", "Fontaine", "Mandelieu-la-Napoule", "Oyonnax", "Combs-la-Ville", "Manosque", "Deuil-la-Barre", "Tassin-la-Demi-Lune", "Loos", "Le Moule", "Millau", "Villeneuve-sur-Lot", "Vélizy-Villacoublay", "Sainte-Foy-lès-Lyon", "Le Petit-Quevilly", "Olivet", "Chaumont", "Auch", "Dammarie-les-Lys", "Bruay-la-Buissière", "Montigny-lès-Metz", "Le Creusot", "Montigny-lès-Cormeilles", "Forbach", "Arcueil", "Montmorency", "Hazebrouck", "Chemillé-en-Anjou", "Villeneuve-le-Roi", "Gif-sur-Yvette", "Couëron", "Lagny-sur-Marne", "Longjumeau", "Saint-Genis-Laval", "Allauch", "Saint-Louis", "La Madeleine", "Gujan-Mestras", "Neuilly-Plaisance", "Coudekerque-Branche", "Les Pennes-Mirabeau", "Croix", "Beaune", "Fleury-les-Aubrais", "Achères", "La Celle-Saint-Cloud", "Morsang-sur-Orge", "Paris 2e Arrondissement", "Le Mée-sur-Seine", "Halluin", "Gardanne", "Sarreguemines", "Mons-en-Barul", "Saint-Jean-de-Braye", "Saint-Gratien", "Dax", "Bourg-la-Reine", "Challans", "Chaville", "Castelnau-le-Lez", "Wasquehal", "Mantes-la-Ville", "Fougères", "Pertuis", "Ozoir-la-Ferrière", "Lisieux", "Montereau-Fault-Yonne"];

        foreach ($noms as $nom) {
            $ville = new Ville();
            $ville->setNom($nom);
            $ville->setCodePostal("37000");

            $manager->persist($ville);
        }

        $manager->flush();
    }

    public function generateFakeUt(ObjectManager $manager)
    {
        $faker = Factory::create();
        $utilisateur=Array();

        for ($i = 0; $i < 50; $i++) {
            $utilisateur[$i] = new Utilisateur();
            $utilisateur[$i]->setNom($faker->lastName);
            $utilisateur[$i]->setPrenom($faker->firstName);
            $veh = $this->generateFakeVehicule($manager);
            $utilisateur[$i]->setVehicule($veh);
            echo "veh:generateFakeUt";
            $manager->persist($veh);
            echo "utilisateur[$i]:generateFakeUt";
            $manager->persist($utilisateur[$i]);
        }

        $manager->flush();
    }
    public function generateFakeUtilisateur(ObjectManager $manager): array
    {
        $faker = Factory::create();
        $utilisateur=Array();

        for ($i = 0; $i < 50; $i++) {
            $utilisateur[$i] = new Utilisateur();
            $utilisateur[$i]->setNom($faker->lastName);
            $utilisateur[$i]->setPrenom($faker->firstName);
            $veh = $this->generateFakeVehicule($manager);
            $utilisateur[$i]->setVehicule($veh);
            echo "veh:generateFakeUtilisateur";
            $manager->persist($veh);
            echo "utilisateur[$i]:generateFakeUtilisateur";
            $manager->persist($utilisateur[$i]);
        }

        $manager->flush();
        return $utilisateur;
        }
        public function generateFakeTrajets(ObjectManager $manager, array $utilisateurs): array
        {
            $faker = Factory::create();
            $trajets = [];

            for ($i = 0; $i < 20; $i++) {
                $trajet = new Trajet();
                $trajet->setDate($faker->dateTimeBetween('-1 month', '+1 month'));
                $trajet->setPrix($faker->randomFloat(2, 10, 100));
                $passagersCount = $faker->numberBetween(1, 5);
                $trajet->setPlaces($passagersCount);
                /* @var$utilisateur Utilisateur */
                $utilisateur = $faker->randomElement($utilisateurs);
                $trajet->setConducteur($utilisateur);
                $utilisateur->addTrajetsConduit($trajet);
                $trajet->setVehicule($trajet->getConducteur()->getVehicule());
                echo "trajet->getConducteur()->getVehicule():generateFakeTrajets";
                $manager->persist($trajet->getConducteur()->getVehicule());
                echo "utilisateur:generateFakeTrajets";
                $manager->persist($utilisateur);
                // Définissez les autres propriétés de Trajet en fonction de votre implémentation

                // Ajout de passagers aléatoires
                for ($j = 0; $j < $passagersCount; $j++) {
                    //$passager = $faker->name;
                    /* @var $passager Utilisateur */
                    $passager = $faker->randomElement($utilisateurs);
                    $trajet->addPassager($passager);
                    $passager->addVoyage($trajet);
                    echo "passager:generateFakeTrajets";
                    $manager->persist($passager);
                }

                $trajet->addAvis($this->generateFakeAvis($manager, $trajet));

                $messages = $this->generateFakeMessages($manager);
                foreach($messages as $message) {
                    $trajet->addMessage($message);
                    echo "message:generateFakeTrajets";
                    $manager->persist($message);
                }

                $trajet->setDepart($this->villes[$faker->randomNumber(1, 39000)]);
                $trajet->setArrivee($this->villes[$faker->randomNumber(1, 39000)]);

                echo "trajet:generateFakeTrajets";
                $manager->persist($trajet);
                $trajets[] = $trajet;
            }

            $manager->flush();
            return $trajets;
        }
        public function generateFakeMessages(ObjectManager $manager, int $count = 50): array
        {
            $faker = Factory::create();
            $messages = array();

            // Récupérez tous les trajets disponibles pour créer des relations
            $trajets = $manager->getRepository(Trajet::class)->findAll();

            for ($i = 0; $i < $count; $i++) {
                $message = new Message();
                $message->setDate($faker->dateTimeBetween('-1 month'));
                $message->setTexte($faker->sentence);

                // Sélectionnez un trajet aléatoire pour établir la relation
                $trajet = $faker->randomElement($trajets);

                $message->setTrajet($trajet);
                echo "trajet:generateFakeMessages";
                $manager->persist($trajet);
                $messages[] = $message;

                echo "message:generateFakeMessages";
                $manager->persist($message);
            }

            $manager->flush();
            return $messages;
        }
        public function addRandomConducteursToVehicule(ObjectManager $manager, Vehicule $vehicule)
        {
            $faker = Factory::create();
            $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();

            $randomConducteurs = $faker->randomElements($utilisateurs);
            foreach ($randomConducteurs as $conducteur) {
                $vehicule->addConducteur($conducteur);
                echo "conducteur:addRandomConducteursToVehicule";
                $manager->persist($conducteur);
            }


            echo "vehicule:addRandomConducteursToVehicule";
            $manager->persist($vehicule);
            $manager->flush();
        }

        
        public function generateFakeAvis(ObjectManager $manager, $trajet)
        {
            $faker = Factory::create();

            // Récupérez tous les trajets et utilisateurs disponibles pour créer des relations
            $trajets = $manager->getRepository(Trajet::class)->findAll();
            $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();

            $avis = new Avis();
            $avis->setDate($faker->dateTimeBetween('-1 year'));
            $avis->setTexte($faker->sentence);
            $avis->setNote($faker->numberBetween(1, 5));

            // Sélectionnez un trajet et un utilisateur aléatoires pour établir les relations
            $utilisateur = $faker->randomElement($utilisateurs);

            $avis->setTrajet($trajet);
            $avis->setUtilisateur($utilisateur);

            echo "trajet:generateFakeAvis";
            $manager->persist($trajet);
            echo "utilisateur:generateFakeAvis";
            $manager->persist($utilisateur);
            echo "avis:generateFakeAvis";
            $manager->persist($avis);

            $manager->flush();
            return $avis;
        }

    public function generateFakeVehicule(ObjectManager $manager): Vehicule
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
        $couleurs = ['#bf0603', '#457b9d', '#000000', '#ffffff', '#404040','#ffd900','#ffd900'];

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
        echo "vehicules:generateFakeVehicules";
        $manager->persist($vehicules);
        
        $manager->flush();

        return $vehicules;
    }

}

