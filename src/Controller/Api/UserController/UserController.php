<?php
namespace App\Controller\Api\UserController;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private HttpClientInterface $client
    ) {}


    #[Route('/register', name: 'register')]
    public function register(Request $request, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        // Get the data from the request
        $user->setUserName($data['userName']);
        $user->setEmail($data['email']);
        $user->setPhoneNumber($data['phoneNumber']);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        // Perform validation on the data
        $errors = $validator->validate($user);

        // If there are any errors, return a response with the errors
        if (count($errors)) {
            return new JsonResponse((string) $errors, 400);
        }

        // If the data is valid, send it to the repository
        $this->em->persist($user);
        $this->em->flush();
        return $this->json($user);
    }


    // public function delete(UserPasswordHasherInterface $passwordHasher, UserInterface $user)
    // {
    //     // ... e.g. get the password from a "confirm deletion" dialog
    //     $plaintextPassword = ...;

    //     if (!$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
    //         throw new AccessDeniedHttpException();
    //     }
    // }
}
