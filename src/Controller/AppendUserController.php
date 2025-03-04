<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppendUserType;
use App\Entity\Users;

final class AppendUserController extends AbstractController
{
    #[Route('/append', name: 'app_append_user')]
    public function append(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(AppendUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $user = $form->getData();
            $userExist = $entityManager->getRepository(Users::class)->findOneBy(['email'=>$user->getEmail()]);
            if (!$userExist) {
                $entityManager->persist($user);
                $entityManager->flush();
                return new Response('Пользователь добавлен');
            } else {
                return new Response('Пользователь с таким электронным адресом уже существует');
            }
        }
        return $this->render('append_user/appendUser.html.twig', ['form' => $form]);
    }
}
