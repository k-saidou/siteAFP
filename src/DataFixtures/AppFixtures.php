<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;
use App\Entity\Actualites;
use App\Entity\Commentaires;
use App\Entity\Users;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($l = 1; $l <= 10; $l++){
            $utilisateur = new Users();

            $utilisateur->setFirstname($faker->firstName())
                        ->setLastname($faker->lastName())
                        ->setAdresse($faker->streetAddress())
                        ->setEmail($faker->email())
                        ->setRoles([])
                        ->setPassword($faker->password())
                        ->setIsVerified($faker->boolean('true'));

            $manager->persist($utilisateur);

            // créer 5 categories fakées

            for($i = 1; $i <= 3; $i++){
                $category = new Categories();
                $category->setLibelle($faker->sentence())
                        ->setImage($faker->imageUrl());                       
                
                $manager->persist($category);

                // créer 3 Actualites fakées

                for($j = 1; $j <= 3; $j++){
                    $actualite = new Actualites();

                    $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                    $actualite->setTitre($faker->sentence())
                            ->setImage($faker->imageUrl())
                            ->setDescription($content)
                            ->setDateAt($faker->dateTimeBetween())
                            ->setIduser($utilisateur)
                            ->setCategory($category);
                          
                    $manager->persist($actualite);

                    for($k = 1; $k <= 3; $k++){
                        $comment = new Commentaires();

                        $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                        $comment->setContenu($content)
                                ->setActu($actualite)
                                ->setRetourcom($utilisateur);

                        $manager->persist($comment);
                    }
                }
            }
        }
        $manager->flush();
    }
}
