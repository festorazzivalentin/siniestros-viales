<?php

namespace App\Controller;

use App\Entity\Rol;
use App\Form\RolType;
use App\Repository\RolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RolController extends AbstractController
{
    #[Route('/rol', name: 'rol_index')]
    public function index(RolRepository $rol): Response
    {
        return $this->render('rol/index.html.twig', [
            'roles' => $rol->findAll(),
        ]);
    }

    #[Route('/rol/new', name: 'rol_new')]
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

    #[Route('/rol/edit/{id}', name: 'rol_edit')]
    public function edit(Request $request, Rol $rol, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(RolType::class, $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('rol_index');
        }

        return $this->render('rol/edit.html.twig', [
            'form' => $form->createView(),
            'rol' => $rol,
        ]);

    }

    #[Route('/rol/delete/{id}', name: 'rol_delete', methods: ['POST'])]
    public function delete(Request $request, Rol $rol, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$rol->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rol_index');
    }

}
