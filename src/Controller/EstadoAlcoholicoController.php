<?php

namespace App\Controller;

use App\Entity\EstadoAlcoholico;
use App\Form\EstadoAlcoholicoType;
use App\Repository\EstadoAlcoholicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstadoAlcoholicoController extends AbstractController
{
    #[Route('/estados_alcoholicos', name: 'estado_alcoholico_index')]
    public function indexAction(EstadoAlcoholicoRepository $estadoAlcoholico): Response
    {
        return $this->render('estado_alcoholico/index.html.twig', [
            'estados' => $estadoAlcoholico->findAll(),
        ]);
    }

    #[Route('/estado_alcoholico/new', name: 'estado_alcoholico_nuevo')]
    public function newAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estadoAlcoholico = new EstadoAlcoholico();

        $form = $this->createForm(EstadoAlcoholicoType::class, $estadoAlcoholico);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoAlcoholico);
            $entityManager->flush();

            return $this->redirectToRoute('estado_alcoholico_index');
        }

        return $this->render('estado_alcoholico/new.html.twig', [
            'form' => $form->createView(),
            'estadoAlcoholico' => $estadoAlcoholico,
        ]);
    }

    #[Route('/estado_alcoholico/edit/{id}', name: 'estado_alcoholico_editar')]
    public function editAction(Request $request, EntityManagerInterface $entityManager, EstadoAlcoholico $estadoAlcoholico): Response {
        $form = $this->createForm(EstadoAlcoholicoType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('estado_alcoholico_index');
        }

        return $this->render('estado_alcoholico/edit.html.twig', [
            'form' => $form->createView(),
            'estado' => $estadoAlcoholico,
        ]);
    }

    #[Route('/estado_alcoholico/delete/{id}', name: 'estado_alcoholico_eliminar')]
    public function deleteAction(EntityManagerInterface $entityManager, EstadoAlcoholico $estadoAlcoholico): Response {
        $entityManager->remove($estadoAlcoholico);
        $entityManager->flush();

        return $this->redirectToRoute('estado_alcoholico_index');
    }
}
