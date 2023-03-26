<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function getEntity(): User
    {
        return (new User())
            ->setUserName('testUser567')
            ->setEmail('test@email.com')
            ->setPhoneNumber('0634567890')
            ->setPassword('$2y$13$i2KifsllYtqj8W9SIUxm2un4tgZ.HS.1d3ZM7gbNvnBIOdO5cZRxS')
            ->setRoles(['ROLE_USER']);
    }


    /**
     * @throws Exception
     */
    public function testUserIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $user = $this->getEntity();
        $errors = $container->get('validator')->validate($user);
        $this->assertCount(0, $errors);
    }

    /**
     * @throws Exception
     */
    public function testPhoneAreValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $user = $this->getEntity()
            ->setPhoneNumber('0712345678');
        $user2 = $this->getEntity()
            ->setPhoneNumber('+33612345678');
        $user3 = $this->getEntity()
            ->setPhoneNumber('0033712345678');
        $user4 = $this->getEntity()
            ->setPhoneNumber('+0033612345678');
        $errors = $container->get('validator')->validate([$user, $user2, $user3, $user4]);
        $this->assertCount(0, $errors);
    }

    /**
     * @throws Exception
     */
    public function testUsernameIsLowerThan3(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setUsername('');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    /**
     * @throws Exception
     */
    public function testEmailIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setEmail('notAnEmail');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    /**
     * @throws Exception
     */
    public function testPasswordIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setPassword('lower');
        $user2 = $this->getEntity()
            ->setPassword('Havenotspecialcharacterornumber');
        $user3 = $this->getEntity()
            ->setPassword('Havenotspecialcharacter34');
        $user4 = $this->getEntity()
            ->setPassword('Havenotnumber!');
        $user5 = $this->getEntity()
            ->setPassword('havenotuppercase67!');
        $user6 = $this->getEntity()
            ->setPassword('havenothingbutlength');


        $errors = $container->get('validator')->validate([$user, $user2, $user3, $user4, $user5, $user6]);
        $this->assertCount(6, $errors);
    }

    /**
     * @throws Exception
     */
    public function testPhoneIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setPhoneNumber('06123456789');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }
}
