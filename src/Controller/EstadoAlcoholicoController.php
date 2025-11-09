<?php

namespace App\Controller;

use App\Entity\EstadoAlcoholico;
use App\Form\EstadoAlcoholicoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstadoAlcoholicoController extends AbstractController
{
    #[Route('/estadoalcoholico', name: 'app_estado_alcoholico')]
    public function index(): Response
    {
        return $this->render('estado_alcoholico/index.html.twig', [
            'controller_name' => 'EstadoAlcoholicoController',
        ]);
    }

    #[Route('/estadoalcoholico/new', name: 'app_estado_alcoholico')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estadoAlcoholico = new EstadoAlcoholico();

        $form = $this->createForm(EstadoAlcoholicoType::class, $estadoAlcoholico);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoAlcoholico);
            $entityManager->flush();
        }

        return $this->render('estado_alcoholico/new.html.twig', [
            'form' => $form->createView(),
            'estadoAlcoholico' => $estadoAlcoholico,
        ]);
    }
}
