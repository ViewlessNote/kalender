<?php
namespace App\Controller;

use App\Entity\Termin;
use App\Service\TerminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding, X-Auth-Token, content-type');
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

    #[Route('/setTermin', name:'setTermin', methods: ['post'])]
    public function MakeTermine(Request $request): JsonResponse
    {
        $newTermin = new Termin();

    $newTermin = $this->serializer->deserialize($request->getContent(), Termin::class, 'json');

        $this->terminService->setNew($newTermin);
        return new JsonResponse($newTermin);
    }
    #[Route('/Termine')]
    public function GetTermine(): JsonResponse
    {
        return new JsonResponse($this->terminService->getAll());
    }

}