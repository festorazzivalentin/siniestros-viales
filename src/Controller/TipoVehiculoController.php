<?php

namespace App\Controller;

use App\Entity\TipoVehiculo;
use App\Form\TipoVehiculoType;
use App\Repository\TipoVehiculoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TipoVehiculoController extends AbstractController
{
    #[Route('/tipo_vehiculo', name: 'tipo_vehiculo_index')]
    public function index(TipoVehiculoRepository $tipoVehiculo): Response
    {
        return $this->render('tipo_vehiculo/index.html.twig', [
            'tipos' => $tipoVehiculo->findAll(),
        ]);
    }

    #[Route('tipo_vehiculo/new', name: 'tipo_vehiculo_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $tipoVehiculo = new TipoVehiculo();

        $form = $this->createForm(TipoVehiculoType::class, $tipoVehiculo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoVehiculo);
            $entityManager->flush();

            return $this->redirectToRoute('app_tipo_vehiculo');
        }

        return $this->render('tipo_vehiculo/new.html.twig', [
            'form' => $form->createView(),
            'tipoVehiculo' => $tipoVehiculo,
        ]);
    }

    #[Route('/tipo_vehiculo/edit/{id}', name: 'tipo_vehiculo_edit')]
    public function edit(Request $request, TipoVehiculo $tipoVehiculo, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(TipoVehiculoType::class, $tipoVehiculo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('tipo_vehiculo_index');
        }

        return $this->render('tipo_vehiculo/edit.html.twig', [
            'form' => $form->createView(),
            'tipoVehiculo' => $tipoVehiculo,
        ]);
    }

    #[Route('/tipo_vehiculo/delete/{id}', name: 'tipo_vehiculo_delete', methods: ['POST'])]
    public function delete(Request $request, TipoVehiculo $tipoVehiculo, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$tipoVehiculo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoVehiculo);
            $entityManager->flush();
        }
        return $this->redirectToRoute('tipo_vehiculo_index');
    }
}

