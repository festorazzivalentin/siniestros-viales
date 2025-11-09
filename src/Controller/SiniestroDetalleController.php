<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Entity\SiniestroDetalle;
use App\Form\SiniestroDetalleType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SiniestroDetalleController extends AbstractController
{
    #[Route('/siniestrodetalle', name: 'app_siniestro_detalle')]
    public function index(): Response
    {
        return $this->render('siniestro_detalle/index.html.twig', [
            'controller_name' => 'SiniestroDetalleController',
        ]);
    }

    #[Route('/siniestrodetalle/new/{id}', name: 'app_siniestro_detalle_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, Siniestro $siniestro): Response
    {
        $siniestroDetalle = new SiniestroDetalle();
        $siniestroDetalle->setSiniestro($siniestro);

        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestroDetalle);
            $entityManager->flush();

            return $this->redirectToRoute('app_siniestro_show_detalles', ['id' => $siniestro->getId()]);
        }

        return $this->render('siniestro_detalle/new.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('siniestrodetalle/edit/{id}', name: 'app_siniestro_detalle_edit')]
    public function editAction(Request $request, EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_siniestro_show_detalles', ['id' => $siniestroDetalle->getSiniestro()->getId()]);
        }

        return $this->render('siniestro_detalle/edit.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
        ]);
    }

    #[Route('siniestrodetalle/delet/{id}', name: 'app_siniestro_detalle_delete')]
    public function deleteAction(EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $siniestroId = $siniestroDetalle->getSiniestro()->getId();
        $entityManager->remove($siniestroDetalle);
        $entityManager->flush();

        return $this->redirectToRoute('app_siniestro_show_detalles', ['id' => $siniestroId]);
    }
}
