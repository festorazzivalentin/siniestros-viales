<?php

namespace App\Controller;

use App\Entity\GrupoEtario;
use App\Form\GrupoEtarioType;
use App\Repository\GrupoEtarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GrupoEtarioController extends AbstractController
{
    #[Route('/grupo_etario', name: 'grupo_etario_index')]
    public function index(GrupoEtarioRepository $grupoEtario): Response
    {
        return $this->render('grupo_etario/index.html.twig', [
            'grupos' => $grupoEtario->findAll(),
        ]);
    }

    #[Route('/grupo_etario/new', name: 'grupo_etario_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grupoEtario = new GrupoEtario();

        $form = $this->createForm(GrupoEtarioType::class, $grupoEtario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grupoEtario);
            $entityManager->flush();

            return $this->redirectToRoute('app_grupo_etario');
        }

        return $this->render('grupo_etario/new.html.twig', [
            'form' => $form->createView(),
            'grupoEtario' => $grupoEtario,
        ]);
    }

    #[Route('/grupo_etario/{id}/edit', name: 'grupo_etario_edit')]
    public function edit(Request $request, GrupoEtario $grupoEtario, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(GrupoEtarioType::class, $grupoEtario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('grupo_etario_index');
        }

        return $this->render('grupo_etario/edit.html.twig', [
            'form' => $form->createView(),
            'grupoEtario' => $grupoEtario,
        ]);
    }

    #[Route('/grupo_etario/{id}/delete', name: 'grupo_etario_delete', methods: ['POST'])]
    public function delete(Request $request, GrupoEtario $grupoEtario, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$grupoEtario->getId(), $request->request->get('_token'))) {
            $entityManager->remove($grupoEtario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grupo_etario_index');
    }
}
