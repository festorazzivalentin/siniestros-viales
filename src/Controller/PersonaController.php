<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PersonaController extends AbstractController
{
    #[Route('/persona', name: 'persona_index')]
    public function index(Request $request, PersonaRepository $personas): Response
    {
        $nombre = $request->query->get('nombre');
        $resultados = $nombre ? $personas->findByNombre($nombre) : $personas->findAll();
        
        return $this->render('persona/index.html.twig', [
            'personas' => $resultados,
        ]);
    }
    
    #[Route('/persona/new', name: 'persona_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {

        $persona = new Persona();

        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($persona);
            $entityManager->flush();

            return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona/new.html.twig', [
            'form' => $form->createView(),
            'persona' => $persona,
        ]); 
    }

    #[Route('/persona/edit/{id}', name: 'persona_edit')]
    public function edit(Request $request, Persona $persona, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona/edit.html.twig', [
            'form' => $form->createView(),
            'persona' => $persona,
        ]);
    }

    #[Route('persona/delete/{id}', name: 'persona_delete')]
    public function delete(Request $request, Persona $persona, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$persona->getId(), $request->request->get('_token'))) {
            $entityManager->remove($persona);
            $entityManager->flush();
        }
        return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('persona/resultados', name: 'persona_buscar')]
    public function buscar(Request $request, PersonaRepository $personaRepository): Response {
        $nombre = $request->query->get('nombre');
        $personas = $personaRepository->findByNombre($nombre);

        return $this->render('persona/resultados.html.twig', [
            'personas' => $personas,
            'nombre' => $nombre,
        ]);
    }
}
