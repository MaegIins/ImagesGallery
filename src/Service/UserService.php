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


    public function controleMdpAndName(string $name, string $password, string $password_confirm): bool
    {
        $test = false;
        if (strlen($name) > 2 && ($password == $password_confirm) && strlen($password) > 3) {
            $test = true;
        }
        return $test;
    }


    public function login(string $name, string $password): bool|int
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
    public function signup(string $name,string $firstname,string $username, string $password, string $password_confirm): bool|int
    {

        $checkMdpAndName = $this->controleMdpAndName($name,$password,$password_confirm);
        $req = $this->em->getRepository(\App\Domain\User::class)->findBy(['name' => $name]);
        if ($req == null && $checkMdpAndName===true) {
            $newUser = new \App\Domain\User($name , $firstname , $username , $password);
            $this->em->persist($newUser);
            $this->em->flush();
            $this->logger->info("UserService::signup($name)");
            return $newUser->getId();
        } elseif ($checkMdpAndName === false ) {
            $this->logger->info("UserService::signup($name) : errorSignup");

        }
        return $checkMdpAndName;
    }

    public function findUserById($id_user):mixed{
        $user = $this->em->getRepository(User::class)->find($id_user);
        //$user_creator = $this->em->getRepository(\App\Domain\User::class)->findBy(['id_user' => 2]);
       // $req = $this->em->getRepository(\App\Domain\User::class)->findBy(['id_user' => $name]);

        return $user;
    }
}


