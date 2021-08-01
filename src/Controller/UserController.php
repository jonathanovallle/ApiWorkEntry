<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends AbstractController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        
    }

    /**
     * @Route("/user/add", name="add_user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $email = $data['email'];
        $createAt = new \DateTimeImmutable($request->get('time'));

        if (empty($name) || empty($email)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($name, $email, $createAt);

        return new JsonResponse(['status' => 'user created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/user", name="list_user", methods={"GET"})
     */
    public function list(Request $request): JsonResponse
    {
        $users = $this->userRepository->findAllUsers();
        return new JsonResponse($users, Response::HTTP_OK);
    }

    /**
     * @Route("/user/{id}", name="user", methods={"GET"})
     */
    public function findUser($id,Request $request): JsonResponse
    {
        $users = $this->userRepository->findUser($id);
        return new JsonResponse($users, Response::HTTP_OK);
    }

     /**
     * @Route("/user/update/{id}", name="update_user", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if(empty($user)){
            throw new NotFoundHttpException('id no existe');
        }
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $user->setName($data['name']);
        empty($data['email']) ? true : $user->setEmail($data['email']);
        $user->setUpdatedAt(new \DateTimeImmutable($request->get('time')));

        $updatedUser = $this->userRepository->updateUser($user);

	    return new JsonResponse(['status' => 'user updated!'], Response::HTTP_OK);
    }

     /**
     * @Route("/user/delete/{id}", name="delete_user", methods={"PUT"})
     */
    public function delete($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if(empty($user)){
            throw new NotFoundHttpException('id no existe');
        }
        $user->setDeletedAt(new \DateTimeImmutable($request->get('time')));

        $updatedUser = $this->userRepository->updateUser($user);

	    return new JsonResponse(['status' => 'user deleted!'], Response::HTTP_OK);
    }
}
