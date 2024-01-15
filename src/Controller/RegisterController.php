<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/register', name: 'register_')]
class RegisterController extends AbstractController
{

    public function __construct(private UserService $userService)
    {

    }

    #[Route('/', name: 'index')]
    public function register(Request $request)
    {
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($this->userService->register($form)){
               return $this->redirectToRoute('home_index');
            }

        }

        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/success', name: 'success')]
    public function success()
    {
        return $this->render('register/success.html.twig');
    }
}
