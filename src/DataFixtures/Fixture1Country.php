<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Country;

class Fixture1Country extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $country = new Country();
            $country->setName($faker->country);
            $country->setIsoCode($faker->countryCode);
            $manager->persist($country);
        
            // Ajoute une référence pour pouvoir récupérer ce pays plus tard
            $this->addReference('country_' . $i, $country);
        }

        $manager->flush();
    }
}
