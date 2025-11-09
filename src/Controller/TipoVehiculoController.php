<?php

namespace App\Controller;

use App\Entity\TipoVehiculo;
use App\Form\TipoVehiculoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TipoVehiculoController extends AbstractController
{
    #[Route('/tipovehiculo', name: 'app_tipo_vehiculo')]
    public function index(): Response
    {
        return $this->render('tipo_vehiculo/index.html.twig', [
            'controller_name' => 'TipoVehiculoController',
        ]);
    }

    #[Route('tipovehiculo/new', name: 'app_tipo_vehiculo_new')]
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
}

