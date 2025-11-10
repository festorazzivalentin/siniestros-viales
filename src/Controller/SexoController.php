<?php

namespace App\Controller;

use App\Entity\Sexo;
use App\Form\SexoType;
use App\Repository\SexoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SexoController extends AbstractController
{
    #[Route('/sexo', name: 'sexo_index')]
    public function index(SexoRepository $sexos): Response
    {
        return $this->render('sexo/index.html.twig', [
            'sexos' => $sexos->findAll(),
        ]);
    }

    #[Route('/sexo/new', name: 'sexo_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sexo = new Sexo();
        $form = $this->createForm(SexoType::class, $sexo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sexo);
            $entityManager->flush();

            return $this->redirectToRoute('sexo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sexo/new.html.twig', [
            'form' => $form->createView(),
            'sexo' => $sexo,
        ]);
    }

    #[Route('/sexo/edit/{id}', name: 'sexo_edit')]
    public function edit(Request $request, Sexo $sexo, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(SexoType::class, $sexo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sexo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sexo/edit.html.twig', [
            'form' => $form->createView(),
            'sexo' => $sexo,
        ]);
    }

    #[Route('/sexo/delete/{id}', name: 'sexo_delete', methods: ['POST'])]
    public function delete(Request $request, Sexo $sexo, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$sexo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sexo);
            $entityManager->flush();
        }
        return $this->redirectToRoute('sexo_index', [], Response::HTTP_SEE_OTHER);
    }

}
