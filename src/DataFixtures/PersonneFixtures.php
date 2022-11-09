<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0; $i<100; $i++){
            $personne = new Personne();
            $personne->setFirstname($faker->firstname);
            $personne->setName($faker->name);
            $personne->setAge($faker->numberBetween(18, 65));
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
