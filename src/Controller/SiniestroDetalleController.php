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
    
    #[Route('/siniestro_detalle/new/{id}', name: 'siniestro_detalle_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, Siniestro $siniestro): Response
    {
        $siniestroDetalle = new SiniestroDetalle();
        $siniestroDetalle->setSiniestro($siniestro);

        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestroDetalle);
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestro->getId()]);
        }

        return $this->render('siniestro_detalle/new.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('siniestro_detalle/edit/{id}', name: 'siniestro_detalle_edit')]
    public function editAction(Request $request, EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestroDetalle->getSiniestro()->getId()]);
        }

        return $this->render('siniestro_detalle/edit.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
        ]);
    }

    #[Route('siniestro_detalle/delete/{id}', name: 'siniestro_detalle_delete')]
    public function deleteAction(EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $siniestroId = $siniestroDetalle->getSiniestro()->getId();
        $entityManager->remove($siniestroDetalle);
        $entityManager->flush();

        return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestroId]);
    }
}
