<?php

namespace App\Controller;

use App\Entity\GrupoEtario;
use App\Form\GrupoEtarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GrupoEtarioController extends AbstractController
{
    #[Route('/grupoetario', name: 'app_grupo_etario')]
    public function index(): Response
    {
        return $this->render('grupo_etario/index.html.twig', [
            'controller_name' => 'GrupoEtarioController',
        ]);
    }

    #[Route('/grupoetario/new', name: 'app_grupo_etario_new')]
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
}
