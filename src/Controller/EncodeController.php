<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;

#[Route('/', methods: ['GET', 'POST'])]
final class EncodeController extends AbstractController
{
    public function __construct(
        private UserPasswordEncoderInterface $userPasswordEncoder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class)
            ->add('submit', SubmitType::class)
            ->getForm()
            ->handleRequest($request)
        ;

        $encoded = null;
        if ($form->isSubmitted() && $form->isValid()) {
            ['password' => $password] = $form->getData();
            $encoded = $this->userPasswordEncoder->encodePassword(new User('dummy', null), $password);
        }

        return $this->render('home.html.twig', [
            'encoded' => $encoded,
            'form' => $form->createView(),
        ]);
    }
}
