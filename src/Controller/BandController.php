<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Concert;
use App\Form\BandType;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BandController extends AbstractController
{
    /**
     * @Route("/bandAdmin", name="band_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(BandRepository $bandRepository): Response
    {
        return $this->render('band/index.html.twig', [
            'bands' => $bandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/bandAdmin/new", name="band_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($band);
            $entityManager->flush();

            return $this->redirectToRoute('band_index');
        }

        return $this->render('band/new.html.twig', [
            'band' => $band,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bandAdmin/{id}", name="band_show", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function show(Band $band): Response
    {
        return $this->render('band/show.html.twig', [
            'band' => $band,
        ]);
    }

    /**
     * @Route("/bandAdmin/{id}/edit", name="band_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Band $band): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('band_index');
        }

        return $this->render('band/edit.html.twig', [
            'band' => $band,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bandAdmin/{id}", name="band_delete", methods={"DELETE"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Band $band): Response
    {
        if ($this->isCsrfTokenValid('delete'.$band->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($band);
            $entityManager->flush();
        }

        return $this->redirectToRoute('band_index');
    }

    /**
     * Affiche une liste de groupe
     *
     * @return Response
     *
     * @Route("/bands", name="band_list")
     */
    public function bandsAll(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);
        $bands = $repository->findAll();
        return $this->render('band/public/list.html.twig', [
                'bands' => $bands
            ]
        );
    }

    /**
     * Affiche une liste de groupe
     *
     * @param int $id
     * @return Response
     *
     * @Route("/band/{id}", name="band_concert")
     */
    public function list(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);

        return $this->render('band/public/band.html.twig', [
                'band' => $repository->find($id),
                'concerts' => $this->getDoctrine()->getRepository(Concert::class)->find10next(),
            ]
        );
    }
}
