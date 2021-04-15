<?php

namespace App\Controller;

use App\Service\ParkService;


use App\Entity\Rate;
use App\Form\RateType;
use App\Repository\RateRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ParkController extends AbstractController
{

    

    /**
     * @Route("/attractions", name="attractions")
     */
    public function index(ParkService $parkService): Response
    {

        $attractions = $parkService->showAllAttractions();
        //dd($attractions);
        

        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractions,
        ]);
    }

    /**
     * @Route("/attractions/{slug}", name="show_one_attraction", methods={"GET","POST"})
     */
    public function showOneAttraction(ParkService $parkService, $slug, Request $request): Response
    {
        $attraction = $parkService->showOneAttraction($slug);
        $rates = $attraction->getRates();
        $total = 0;
        $count = count($rates);
        foreach($rates as $rate){
            //dd($rate->getRate());
            $total += $rate->getRate();
        }
        if($count > 0) {
            $moyenne = $total/$count;
        } else {
            $moyenne = 0;
        }
        $attraction->setRate($moyenne);

        $rate = new Rate();
        $rate->setAttraction($attraction);
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            $rate = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rate);
            $entityManager->flush();
            //return $this->redirectToRoute('attractions');
        }

        return $this->render('attraction/show.html.twig', [
            'rate' => $rate,
            'form'=> $form->createView(),
            'attraction' => $attraction,
            'note'=>$moyenne
        ]);

    }
    
}
