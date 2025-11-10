<?php

namespace App\Controller;

use App\Entity\Clima;
use App\Form\ClimaType;
use App\Repository\ClimaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ClimaController extends AbstractController
{
    #[Route('/clima', name: 'clima_index')]
    public function indexAction(ClimaRepository $climaRepository): Response
    {
        return $this->render('clima/index.html.twig', [
            'climas' => $climaRepository->findAll(),
        ]);
    }

    #[Route('/clima/new', name: 'clima_nuevo')]
    public function newAction(Request $request, EntityManagerInterface $entityManager): Response {
        $clima = new Clima();

        $form = $this->createForm(ClimaType::class, $clima);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($clima);
            $entityManager->flush();

            return $this->redirectToRoute('clima_index');
        }

        return $this->render('clima/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/clima/edit/{id}', name: 'clima_editar')]
    public function editAction(Request $request, EntityManagerInterface $entityManager, Clima $clima): Response {
        $form = $this->createForm(ClimaType::class, $clima);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('clima_index');
        }

        return $this->render('clima/edit.html.twig', [
            'form' => $form->createView(),
            'clima' => $clima,
        ]);
    }

    #[Route('/clima/delete/{id}', name: 'clima_eliminar')]
    public function deleteAction(EntityManagerInterface $entityManager, Clima $clima): Response {
        $entityManager->remove($clima);
        $entityManager->flush();

        return $this->redirectToRoute('clima_index');
    }
}
