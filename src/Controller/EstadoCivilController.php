<?php

namespace App\Controller;

use App\Entity\EstadoCivil;
use App\Form\EstadoCivilType;
use App\Repository\EstadoCivilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class EstadoCivilController extends AbstractController
{
    #[Route('/estado_civil', name: 'estado_civil_index')]
    public function indexAction(EstadoCivilRepository $estadoCivil): Response
    {
        return $this->render('estado_civil/index.html.twig', [
            'estados' => $estadoCivil->findAll(),
        ]);
    }

    #[Route('/estado_civil/new', name: 'estado_civil_nuevo')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $estadoCivil = new EstadoCivil();

        $form = $this->createForm(EstadoCivilType::class, $estadoCivil);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoCivil);
            $entityManager->flush();

            return $this->redirectToRoute('estado_civil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_civil/new.html.twig', [
            'form' => $form->createView(),
            'estado' => $estadoCivil,
        ]);
    }

    #[Route('/estado_civil/edit/{id}', name: 'estado_civil_editar')]
    public function edit(Request $request, EntityManagerInterface $entityManager, EstadoCivil $estadoCivil): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(EstadoCivilType::class, $estadoCivil);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('estado_civil_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('estado_civil/edit.html.twig', [
            'form' => $form->createView(),
            'estado' => $estadoCivil,
        ]);
    }

    #[Route('/estado_civil/delete/{id}', name: 'estado_civil_eliminar')]
    public function delete(EntityManagerInterface $entityManager, EstadoCivil $estadoCivil): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager->remove($estadoCivil);
        $entityManager->flush();
        
        return $this->redirectToRoute('estado_civil_index', [], Response::HTTP_SEE_OTHER);
    }
}
