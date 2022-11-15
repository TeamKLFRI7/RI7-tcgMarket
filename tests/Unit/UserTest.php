<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function getEntity(): User
    {
        return (new User())
            ->setUsername('testUser567')
            ->setEmail('test@email.com')
            ->setIsAdmin(false)
            ->setCreateAt(new \DateTimeImmutable())
            ->setPassword('testpasssword69E.=')
            ->setPhoneNumber('0634567890');
    }

    public function testUserIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity();

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(0, $errors);
    }

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

    public function testUsernameIsLowerThan3(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setUsername('');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testEmailIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setEmail('notAnEmail');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

    public function testPasswordIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity()
            ->setPassword('lowerT8');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1, $errors);
    }

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
