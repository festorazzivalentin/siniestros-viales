<?php

namespace App\Controller;

use App\Entity\Rol;
use App\Form\RolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RolController extends AbstractController
{
    #[Route('/rol', name: 'app_rol')]
    public function index(): Response
    {
        return $this->render('rol/index.html.twig', [
            'controller_name' => 'RolController',
        ]);
    }

    #[Route('/rol/new', name: 'app_rol_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rol = new Rol();

        $form = $this->createForm(RolType::class, $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rol);
            $entityManager->flush();

            return $this->redirectToRoute('app_rol');
        }

        return $this->render('rol/new.html.twig', [
            'form' => $form->createView(),
            'rol' => $rol,
        ]);
    }
}
