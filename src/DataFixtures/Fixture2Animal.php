<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Animal;
use App\Entity\Country;
use Fixture1Country;

class Fixture2Animal extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // get all countries
        $countries = $manager->getRepository(Country::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $animal = new Animal();
            $animal->setName($faker->name);
            $animal->setAverageSize($faker->randomFloat(2, 0.1, 10));
            $animal->setAverageLifespan($faker->numberBetween(1, 100));
            $animal->setMartialArt($faker->word);
            $animal->setPhoneNumber($faker->phoneNumber);
        
            // Récupère un pays aléatoire et le définis pour l'animal
            $country = $this->getReference('country_' . $faker->numberBetween(0, 9));
            $animal->setCountry($country);
            
            $manager->persist($animal);
        }
    
        $manager->flush();
    }
}

