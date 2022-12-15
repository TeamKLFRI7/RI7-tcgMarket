<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture{

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){

        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void{
        // $product = new Product();
        // $manager->persist($product);

        //Création de l'objet Faker
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++){

            //On crée 10 nouveaux users
            $user = new User();
            $user->setUserName($faker->firstName());
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setPhoneNumber('0653536278');
            $user->setPassword($this->hasher->hashPassword($user, 'Azerty123!'));
            $manager->persist($user);

        }

        //On Crée 1 admin
        $admin = new User;
        $admin->setUserName('Big');
        $admin->setEmail('admin@gmail.com');
        $admin->setPhoneNumber('0653536278');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'Azerty123!'));
        $manager->persist($admin);

        $manager->flush();
    }
}