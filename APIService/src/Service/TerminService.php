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
    public function getTermine(){
        return $this->terminRepository->getTermine();
    }
    public function setNew(Termin $termin){
        $this->terminRepository->setNewTermin($termin);
        return;
    }
    public function getTermin(int $id){
       return $this->terminRepository->getTermin($id);
    }
    public function deleteTermin(int $id){
        $this->terminRepository->deleteTermin($id);
        return;
    }
    public function updateTermin(int $id, Termin $termin){
        $this->terminRepository->updateTermin($id, $termin);
    }
}