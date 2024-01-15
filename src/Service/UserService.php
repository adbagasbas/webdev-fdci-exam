<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class UserService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function register(FormInterface $form): bool
    {
        try {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return true;
        }catch (\Exception $exception){
            return false;
        }
    }
}