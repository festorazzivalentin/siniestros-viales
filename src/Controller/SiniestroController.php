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
    #[Route('/siniestro', name: 'siniestro_index', methods: ['GET'])]
    public function index(Request $request, SiniestroRepository $siniestroRepository): Response
    {
        $fecha = $request->query->get('fecha');
        $siniestros = $siniestroRepository->findByFecha($fecha);

        return $this->render('siniestro/index.html.twig', [
            'siniestros' => $siniestros,
            'fecha' => $fecha,
        ]);
    }

    #[Route('/siniestro/new', name: 'siniestro_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $siniestro = new Siniestro();

        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestro);
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('siniestro/new.html.twig', [
            'form' => $form->createView(),
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}', name: 'siniestro_show', methods: ['GET'])]
    public function show(Siniestro $siniestro): Response {
        return $this->render('siniestro/show.html.twig', [
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}/detalles', name: 'siniestro_detalles')]
    public function showDetalles(Siniestro $siniestro): Response {
        return $this->render('siniestro/show_detalles.html.twig', [
            'siniestro' => $siniestro,
            'detalles' => $siniestro->getSiniestroDetalles(),
        ]);
    }

    #[Route('/siniestro/edit/{id}', name: 'siniestro_edit')]
    public function edit(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('siniestro/edit.html.twig', [
            'form' => $form->createView(),
            'siniestro' => $siniestro,
        ]);

    }

    #[Route('/siniestro/delete/{id}', name: 'siniestro_delete', methods: ['POST'])]
    public function delete(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$siniestro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($siniestro);
            $entityManager->flush();
        }
        return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
    }
}
