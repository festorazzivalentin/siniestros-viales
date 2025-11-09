<?php

namespace App\Controller;

use App\Entity\Clima;
use App\Form\ClimaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ClimaController extends AbstractController
{
    #[Route('/clima', name: 'app_clima')]
    public function index(): Response
    {
        return $this->render('clima/index.html.twig', [
            'controller_name' => 'ClimaController',
        ]);
    }

    #[Route('/clima/new', name: 'app_clima_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $clima = new Clima();

        $form = $this->createForm(ClimaType::class, $clima);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($clima);
            $entityManager->flush();

            return $this->redirectToRoute('app_clima');
        }

        return $this->render('clima/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
