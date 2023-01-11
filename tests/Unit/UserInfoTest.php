<?php

namespace App\Tests\Unit;

use App\Entity\UserInfo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserInfoTest extends KernelTestCase
{

    public function getEntity(): UserInfo
    {
        return (new UserInfo())
            ->setAddress('1 rue du test')
            ->setCity('testCity')
            ->setPostalCode('13000')
            ->setCountry('France')
            ->setDeliveryAddress('1 rue du test')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. 
                Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. 
                Cras elementum ultrices diam'
            );
    }

    public function testUserInfoIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity();

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(0, $errors);
    }

    public function testUserInfoAdressIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setAddress('1 rue bien trop longue de france')
            ->setDeliveryAddress('1 rue bien trop longue de france');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testUserInfoCityIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setCity('Nom-de-ville-bien-trop-long-pour-être-valide-en-france-en-tout-cas');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testUserInfoPostalCodeIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setPostalCode('99000');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }
}
