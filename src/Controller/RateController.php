<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Form\RateType;
use App\Repository\RateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rate")
 */
class RateController extends AbstractController
{
    /**
     * @Route("/", name="rate_index", methods={"GET"})
     */
    public function index(RateRepository $rateRepository): Response
    {
        return $this->render('rate/index.html.twig', [
            'rates' => $rateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rate = new Rate();
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rate);
            $entityManager->flush();

            return $this->redirectToRoute('rate/rate_index');
        }

        return $this->render('rate/new.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rate_show", methods={"GET"})
     */
    public function show(Rate $rate): Response
    {
        return $this->render('rate/show.html.twig', [
            'rate' => $rate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rate $rate): Response
    {
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rate_index');
        }

        return $this->render('rate/edit.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rate_delete", methods={"POST"})
     */
    public function delete(Request $request, Rate $rate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rate_index');
    }
}
