<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }


    #[Route('/api/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userName = htmlspecialchars(trim($data['userName']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $password = htmlspecialchars(trim($data['password']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        $phoneNumber = trim($data['phoneNumber']);

        $user = new User();
        // Get the data from the request
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setPhoneNumber($phoneNumber);
        $user->setPlainPassword($password);

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        // Perform validation on the data
        $errors = $validator->validate($user);

        // If there are any errors, return a response with the errors
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $property = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorMessages[$property] = $message;
            }

            return new JsonResponse($errorMessages, 400);
        }
        // If the data is valid, send it to the repository
        $this->em->persist($user);
        $this->em->flush();

        return  $this->json($user);
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
