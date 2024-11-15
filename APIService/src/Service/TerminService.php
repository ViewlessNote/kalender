<?php
namespace App\Service;
use App\Entity\Termin;
use App\Repository\TerminRepository;

class TerminService
{
    private TerminRepository $terminRepository;
    function __construct(TerminRepository $terminRepository){
        $this->terminRepository = $terminRepository;
    }
    public function getAll(){
        return $this->terminRepository->findAll();
    }
    public function setNew(Termin $termin){
        $this->terminRepository->setNewTermin($termin);
        return;
    }
}