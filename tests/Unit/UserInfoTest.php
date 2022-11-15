<?php

namespace App\Tests\Unit;

use App\Entity\UserInfo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserInfoTest extends KernelTestCase
{

    public function getEntity(): UserInfo
    {
        return (new UserInfo())
            ->setAdress('1 rue du test')
            ->setCountry('France')
            ->setCity('testcity')
            ->setZipCode('13000')
            ->setDeliveryAdress('1 rue du test')
            ->setDescription(
                'Lorem ipsum dolor sit amet. Est praesentium corporis et doloremque asperiores cum porro 
                enim et velit odit qui consequatur dolorem. Eum nemo atque At commodi amet est cupiditate assumenda et 
                neque cupiditate ut nostrum Quis aut assumenda blanditiis est illo aperiam.'
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

    public function testUserInfoCitytolong(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setCity('city-who-is-to-long-for-being-in-France-because-its-forty-five-letter-max');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testUserInfoAdresstolong(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setAdress('155 rue nom le plus de france');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testUserInfoZipCodeIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setZipCode('99000');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }
}
