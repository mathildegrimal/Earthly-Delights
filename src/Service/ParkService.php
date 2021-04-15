<?php

namespace App\Service;

use App\Entity\Attraction;
use Doctrine\ORM\EntityManagerInterface;

class ParkService {


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function showAllAttractions(){
        $attractions = $this->entityManager->getRepository(Attraction::class)->findAll();
        return $attractions;

    }

    public function showOneAttraction($slug){
        $attraction = $this->entityManager->getRepository(Attraction::class)->findOneBySlug($slug);
        return $attraction;
    }  
    
    

}

