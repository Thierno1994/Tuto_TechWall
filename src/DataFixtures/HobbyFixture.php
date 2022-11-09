<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Yoga",
            "Cuisine",
            "Pâtisserie",
            "Photographie",
            "Blogging",
            "Lecture",
            "Apprendre une langue",
            "Construction leggo",
            "Dessin",
            "Coloriage",
            "Peinture",
            "Se lanceer dans le tissage de tapis",
            "Créer des vêtements ou des cosplays",
            "Fabriquer des bijoux",
            "Travailler le metal",
            "Décorer des galets",
            "Faire des puzzles avec de plus en plus de pièce",
            "Créer des miniature (maisons, voiture, trains, bateaux..?)",
            "Améliorer son espace de vie",
            "Apprendre à jongler",
            "Faire partir d'un club de lecture",
            "Apprendre la programmation informatique",
            "En apprendre plus sur le survivalisme",
            "Créer une chaîne youtube",
            "Jouer au fléchettes",
            "Apprendre à chanter"
        ];

        for($i=0; $i < count($data); $i++){
            $hobby = new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
