<?php

namespace App\Controller;

use App\Entity\EstadoCivil;
use App\Form\EstadoCivilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class EstadoCivilController extends AbstractController
{
    #[Route('/estadocivil', name: 'app_estado_civil')]
    public function index(): Response
    {
        return $this->render('estado_civil/index.html.twig', [
            'controller_name' => 'EstadoCivilController',
        ]);
    }

    #[Route('/estadocivil/new', name: 'app_estado_civil')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $estadoCivil = new EstadoCivil();

        $form = $this->createForm(EstadoCivilType::class, $estadoCivil);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoCivil);
            $entityManager->flush();

            return $this->redirectToRoute('app_estado_civil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_civil/new.html.twig', [
            'form' => $form->createView(),
            'estadoCivil' => $estadoCivil,
        ]);
    }
}
