<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkEntryController extends AbstractController
{
    private $workEntryRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository, WorkEntryRepository $workEntryRepository)
    {
        $this->userRepository = $userRepository;
        $this->workEntryRepository = $workEntryRepository;
        
    }
    /**
     * @Route("/user/{id}/workEntryAdd", name="add_workEntry", methods={"POST"})
     */
    public function add($id,Request $request): JsonResponse
    {
        
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $userId = $user;
        $createdAt = new \DateTimeImmutable($request->get('time'));
        $startDate = new \DateTimeImmutable($request->get('time'));

        if (empty($userId)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->workEntryRepository->saveWorkEntry($userId, $createdAt, $startDate);

        return new JsonResponse(['status' => 'workEntry created!'], Response::HTTP_CREATED);
    }

   /**
     * @Route("/user/workEntries/{id}", name="list_workEntries", methods={"GET"})
     */
    public function workEntrybyId($id,Request $request): JsonResponse
    {
        $workEntry = $this->workEntryRepository->findWorkEntryById($id);
        return new JsonResponse($workEntry, Response::HTTP_OK);
    }

    /**
     * @Route("/user/{id}/workEntries", name="list_workEntries_by_user", methods={"GET"})
     */
    public function workEntrybyUserId($id,Request $request): JsonResponse
    {
        $workEntry = $this->workEntryRepository->findWorkEntryByUserId($id);
        return new JsonResponse($workEntry, Response::HTTP_OK);
    }

    /**
     * @Route("/user/workEntry/delete/{id}", name="delete_workEntry", methods={"PUT"})
     */
    public function delete($id, Request $request): JsonResponse
    {
        $workEntry = $this->workEntryRepository->findOneBy(['id' => $id]);
        $workEntry->setDeletedAt(new \DateTimeImmutable($request->get('time')));

        $updatedWorkEntry = $this->workEntryRepository->updateWorkEntry($workEntry);

	    return new JsonResponse(['status' => 'workEntry deleted!'], Response::HTTP_OK);
    }

    /**
     * @Route("/user/workEntry/update/{id}", name="update_workEntry", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $workEntry = $this->workEntryRepository->findOneBy(['id' => $id]);
        $workEntry->setEndDate(new \DateTimeImmutable($request->get('time')));
        $updatedWorkEntry = $this->workEntryRepository->updateWorkEntry($workEntry);

	    return new JsonResponse(['status' => 'workEntry updated!'], Response::HTTP_OK);
    }
}
