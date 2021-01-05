<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use Doctrine\Bundle\DoctrineBundle\Dbal\Logging\BacktraceLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ConcertController extends AbstractController
{
    /**
     * @Route("/concerts", name="concert_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(ConcertRepository $concertRepository): Response
    {
        return $this->render('concert/index.html.twig', [
            'concerts' => $concertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="concert_next", methods={"GET"})
     */
    public function nextConcerts(ConcertRepository $concertRepository): Response
    {

        return $this->render('concert/public/concert.html.twig', [
            'concerts' => $concertRepository->find10next()
        ]);
    }

    /**
     * @Route("/concerts/new", name="concert_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $concert = new Concert();
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($concert);
            $entityManager->flush();

            return $this->redirectToRoute('concert_index');
        }

        return $this->render('concert/new.html.twig', [
            'concert' => $concert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/concerts/{id}", name="concert_show", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function show(Concert $concert): Response
    {
        return $this->render('concert/show.html.twig', [
            'concert' => $concert,
        ]);
    }

    /**
     * @Route("/concerts/{id}/edit", name="concert_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Concert $concert): Response
    {
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('concert_index');
        }

        return $this->render('concert/edit.html.twig', [
            'concert' => $concert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/concerts/{id}", name="concert_delete", methods={"DELETE"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Concert $concert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($concert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('concert_index');
    }
}
