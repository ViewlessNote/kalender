<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Termin;
use TerminService;
use Symfony\Component\Serializer\SerializerInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding, X-Auth-Token, content-type');
// src/Controller/ControllerClass.php

class ControllerClass
{
    private TerminService $terminService;
    private SerializerInterface $serializer;
    public function __constructor (TerminService $terminService, SerializerInterface $serializer){
        $this->terminService = $terminService;
        $this->serializer = $serializer;
    }

    #[Route('/setTermin', name:'setTermin', methods: ['post'])]
    public function MakeTermine(Request $request): JsonResponse
    {
        $newTermin = new Termin();
        $newTermin = $this->serializer->deserialize($request->getContent(), Termin::class, 'json');

        $this->terminService->setNew($newTermin);
        return new JsonResponse($this->terminService->getAll());
    }
    #[Route('/Termine')]
    public function GetTermine(): JsonResponse
    {
        return new JsonResponse($this->terminService->getAll());
    }
    #[Route('/Aufgabe')]
    public function getAufgabe(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html lang="de"><body>Lucky number: '.$number.'</body></html>'
        );
    }
    #[Route('/Aufgabe')]
    public function setAufgaben(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html lang="de"><body>Lucky number: '.$number.'</body></html>'
        );
    }

}