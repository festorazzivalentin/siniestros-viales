<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Form\SiniestroType;
use App\Repository\SiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SiniestroController extends AbstractController
{
    #[Route('/siniestro', name: 'app_siniestro', methods: ['GET'])]
    public function index(SiniestroRepository $siniestroRepository): Response
    {
        return $this->render('siniestro/index.html.twig', [
            'siniestros' => $siniestroRepository->findAll(),
        ]);
    }

    #[Route('/siniestro/new', name: 'app_siniestro_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $siniestro = new Siniestro();

        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestro);
            $entityManager->flush();

            return $this->redirectToRoute('app_siniestro', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('siniestro/new.html.twig', [
            'form' => $form->createView(),
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}', name: 'app_siniestro_show', methods: ['GET'])]
    public function show(Siniestro $siniestro): Response {
        return $this->render('siniestro/show.html.twig', [
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}/detalles', name: 'app_siniestro_show_detalles')]
    public function showDetalles(Siniestro $siniestro): Response {
        return $this->render('siniestro/show_detalles.html.twig', [
            'siniestro' => $siniestro,
            'detalles' => $siniestro->getSiniestroDetalles(),
        ]);
    }
}
