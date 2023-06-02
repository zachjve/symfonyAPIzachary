<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login_check", name="app_login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        return $this->json([
            'user' => $this->getUser() ? $this->getUser()->getName() : null,
        ]);
    }

    /**
    * @Route("/register", name="app_register", methods={"POST"})
    */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $em->getRepository(User::class)->findOneBy(['name' => $data['name']]);
        if ($existingUser) {
            return $this->json([
                'status' => 'Error',
                'message' => 'User already exists'
            ], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setPassword($passwordEncoder->encodePassword($user, $data['password']));

        $em->persist($user);
        $em->flush();

        return $this->json([
            'status' => 'User created successfully',
            'user' => [
                'name' => $user->getName(),
                'id' => $user->getId(),
            ],
        ], 201);
    }

    /**
     * @Route("/api/delete/{id}", name="app_delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json([
                'status' => 'Error',
                'message' => 'User not found'
            ], 404);
        }

        $em->remove($user);
        $em->flush();

        return $this->json([
            'status' => 'Success',
            'message' => 'User deleted successfully'
        ], 200);
    }

}
