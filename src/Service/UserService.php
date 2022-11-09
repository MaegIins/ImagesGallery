<?php

namespace App\Service;

use App\Domain\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;

class UserService
{
    private EntityManager $em;
    private LoggerInterface $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function login(string $name, string $password) : bool|int
    {
        $req = $this->em->getRepository(\App\Domain\User::class)->findBy(['name' => $name]);
        $this->logger->info("UserService::get($name)");
        if ($req == null) {
            $this->logger->info("UserService::get($name) : user not found");
            return false;
        } else {
            if ($req[0]->checkPassword($password)) {
                $this->logger->info("UserService::get($name) : user found");
                return $req[0]->getId();
            } else {
                $this->logger->info("UserService::get($name) : wrong password");
                return false;
            }
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function signup(string $name, string $password, string $password_confirm): bool|int
    {
        if (strlen($name)>2 && ($password == $password_confirm) && strlen($password)>3) {
            $newUser = new \App\Domain\User($name, $password);
            $this->em->persist($newUser);
            $this->em->flush();
            $this->logger->info("UserService::signup($name)");
            return $newUser->getId();
        } else {
            $this->logger->info("UserService::signup($name) : error");
            return false;
        }
    }


    public function forTestAddUSer(string $name, string $username, string $password){
        $user = new User($name, $username, $password);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function findUserById($id_user):mixed{
        $user_creator = $this->em->getRepository(\App\Domain\User::class)->findBy(['id_user' => 2]);
        return $user_creator[0];
    }
}
