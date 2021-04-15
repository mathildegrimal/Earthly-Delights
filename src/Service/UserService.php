<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {


    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder){
        $this->entityManager = $entityManager;
        $this->passwordEncoder= $passwordEncoder;
    }

    public function newUser($user){
               
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setSlug($user->getNickname());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

    }

    

}

