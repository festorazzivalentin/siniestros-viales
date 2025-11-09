<?php

namespace App\Controller;

use App\Entity\Sexo;
use App\Form\SexoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SexoController extends AbstractController
{
    #[Route('/sexo', name: 'app_sexo')]
    public function index(): Response
    {
        return $this->render('sexo/index.html.twig', [
            'controller_name' => 'SexoController',
        ]);
    }

    #[Route('/sexo/new', name: 'app_sexo_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sexo = new Sexo();
        $form = $this->createForm(SexoType::class, $sexo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sexo);
            $entityManager->flush();

            return $this->redirectToRoute('app_sexo', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sexo/new.html.twig', [
            'form' => $form->createView(),
            'sexo' => $sexo,
        ]);
    }
}
