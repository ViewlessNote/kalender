<?php
namespace App\Controller;

use App\Entity\Termin;
use App\Service\TerminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

// src/Controller/ControllerClass.php

class ControllerClass extends AbstractController
{
    private TerminService $terminService;
    private SerializerInterface $serializer;
    public function __construct(TerminService $terminService, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->terminService = $terminService;
    }

    //POST
    #[Route('/setTermin', name:'setTermin', methods: ['POST'])]
    public function MakeTermine(Request $request): JsonResponse
    {
        $newTermin = new Termin();

        $newTermin = $this->serializer->deserialize($request->getContent(), Termin::class, 'json');

        $this->terminService->setNew($newTermin);
        return new JsonResponse($newTermin);
    }
    //GET
    #[Route('/Termine',methods: ['GET'])]
    public function getTermine(): JsonResponse
    {
        $data = $this->serializer->serialize($this->terminService->getTermine(), 'json');
        return new JsonResponse($data);
    }

    #[Route('/Termin/{id}', methods: ['GET'])]
    public function getTermin(int $id):JsonResponse
    {
        $data = $this->serializer->serialize($this->terminService->getTermin($id), 'json');
        return new JsonResponse($data);
    }
    //PUT
    #[Route('/Termin/{id}/change', methods: ['PUT'])]
    public function changeTermin(int $id, Request $request):JsonResponse
    {
        $newTermin = new Termin();

        $newTermin = $this->serializer->deserialize($request->getContent(), Termin::class, 'json');

        $this->terminService->updateTermin($id,$newTermin);
        return new JsonResponse($newTermin);
    }
    //DELETE
    #[Route('/Termin/{id}', methods: ['DELETE'])]
    public function delTermin(int $id):JsonResponse
    {
        $this->terminService->deleteTermin($id);
        return new JsonResponse("Termin deleted successfully");
    }

}