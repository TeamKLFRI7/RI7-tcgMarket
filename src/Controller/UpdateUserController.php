<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateUserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }
    #[Route('/api/updateUser', name: 'updateUser', methods: ['PUT'])]
    public function update(Request $request) :JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userId = $data['userId'];
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new BadRequestHttpException('Id non valide');
        }

        $user->setUsername($data['userName']);
        $user->setEmail($data['email']);
        $user->setPhoneNumber($data['phoneNumber']);

        $userInfo = $user->getUserInfo();
        if (!$userInfo) {

            $userInfo = (new UserInfo())
                ->setFkIdUser($user)
                ->setCity($data['city'])
                ->setCountry($data['country'])
                ->setAddress($data['address'])
                ->setDescription($data['description'])
                ->setDeliveryAddress($data['deliveryAddress'])
                ->setPostalCode($data['postalCode']);

            $user->setUserInfo($userInfo);

        } else {
            $userInfo->setCity($data['city']);
            $userInfo->setCountry($data['country']);
            $userInfo->setAddress($data['address']);
            $userInfo->setDescription($data['description']);
            $userInfo->setDeliveryAddress($data['deliveryAddress']);
            $userInfo->setPostalCode($data['postalCode']);
        }


        $this->entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}