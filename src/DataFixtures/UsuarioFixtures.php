<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usuario = new Usuario();
        $usuario->setEmail('admin@admin.com');
        $hashedPassword = $this->passwordHasher->hashPassword($usuario, 'admin123');
        $usuario->setPassword($hashedPassword);
        $usuario->setRoles(['ROLE_ADMIN']);

        $manager->persist($usuario);
        $manager->flush();
    }
}