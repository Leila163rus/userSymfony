<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class DeleteUserController extends AbstractController
{
    #[Route('/delete', name: 'app_delete_user')]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$user = new Users();
        $form = $this->createFormBuilder()
            ->add('id', IntegerType::class, ['label' => 'Введите id пользователя', 'attr' => ['placeholder' => '5']])
            ->add('save', SubmitType::class, ['label' => 'Удалить пользователя'])
            ->getForm();
        $form->handleRequest($request);  

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $id = $form->getData();
            $userExist = $entityManager->getRepository(Users::class)->findOneBy(['id'=>$id]);
            if ($userExist) {
                $entityManager->remove($userExist);
                $entityManager->flush();
                return new Response('Пользователь удален');
            } else {
                return new Response('Пользователя с таким id не существует');
            }
        }      
        return $this->render('delete_user/deleteUser.html.twig', ['form' => $form]);
    }
}
