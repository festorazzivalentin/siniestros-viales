<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PersonaController extends AbstractController
{
    #[Route('/persona', name: 'app_persona')]
    public function index(): Response
    {
        return $this->render('persona/index.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/persona/new', name: 'app_persona_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        
        $persona = new Persona();

        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($persona);
            $entityManager->flush();

            return $this->redirectToRoute('app_persona', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona/new.html.twig', [
            'form' => $form->createView(),
            'persona' => $persona,
        ]); 
    }
}
