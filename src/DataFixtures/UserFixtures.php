<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Create admin user
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setPassword(
            $this->passwordEncoder->encodePassword($admin, 'password')
        );

        $manager->persist($admin);

        // Create regular user
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'password')
        );

        $manager->persist($user);
        $manager->flush();

        echo "✅ Admin user created successfully!\n";
        echo "   Email: admin@gmail.com\n";
        echo "   Password: password\n";
        echo "   Roles: ROLE_ADMIN, ROLE_USER\n\n";
        echo "✅ Regular user created successfully!\n";
        echo "   Email: user@gmail.com\n";
        echo "   Password: password\n";
        echo "   Roles: ROLE_USER\n";
    }
}
