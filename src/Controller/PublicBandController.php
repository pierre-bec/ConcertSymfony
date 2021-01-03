<?php

namespace App\Controller;

use App\Entity\Band;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicBandController extends AbstractController
{

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
                'band' => $repository->find($id)
            ]
        );
    }
}
