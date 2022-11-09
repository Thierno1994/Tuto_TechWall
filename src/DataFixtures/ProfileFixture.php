<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profile1 = new Profile();
        $profile1->setRs('Facebook');
        $profile1->setUrl('www.facebook.com');

        $profile2 = new Profile();
        $profile2->setRs('Twitter');
        $profile2->setUrl('www.twitter.com');

        $profile3 = new Profile();
        $profile3->setRs('Github');
        $profile3->setUrl('www.github.com');
        
        $profile4 = new Profile();
        $profile4->setRs('LinkedIn');
        $profile4->setUrl('www.linkedin.com');

        $manager->persist($profile1);
        $manager->persist($profile2);
        $manager->persist($profile3);
        $manager->persist($profile4);
        $manager->flush();
    }
}
