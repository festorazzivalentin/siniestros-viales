<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Entity\SiniestroDetalle;
use App\Form\SiniestroDetalleType;
use App\Repository\SiniestroDetalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

final class SiniestroDetalleController extends AbstractController
{
    
    #[Route('/siniestro_detalle/new/{id}', name: 'siniestro_detalle_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, Siniestro $siniestro): Response
    {
        $siniestroDetalle = new SiniestroDetalle();
        $siniestroDetalle->setSiniestro($siniestro);

        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestroDetalle);
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestro->getId()]);
        }

        return $this->render('siniestro_detalle/new.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('siniestro_detalle/edit/{id}', name: 'siniestro_detalle_edit')]
    public function editAction(Request $request, EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(SiniestroDetalleType::class, $siniestroDetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestroDetalle->getSiniestro()->getId()]);
        }

        return $this->render('siniestro_detalle/edit.html.twig', [
            'form' => $form->createView(),
            'siniestro_detalle' => $siniestroDetalle,
        ]);
    }

    #[Route('siniestro_detalle/delete/{id}', name: 'siniestro_detalle_delete')]
    public function deleteAction(EntityManagerInterface $entityManager, SiniestroDetalle $siniestroDetalle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $siniestroId = $siniestroDetalle->getSiniestro()->getId();
        $entityManager->remove($siniestroDetalle);
        $entityManager->flush();

        return $this->redirectToRoute('siniestro_detalles', ['id' => $siniestroId]);
    }

    #[Route('siniestro_detalle/reportes/victima_autor', name: 'siniestro_detalle_reportes_victima_autor')]
    public function reportesVictimaAutor(ChartBuilderInterface $chartBuilder, SiniestroDetalleRepository $repo): Response 
    {
        $datos = $repo->contarVictimaAutor();

        foreach ($datos as $dato) {
            $labels[] = $dato['rol'];
            $cantidades[] = $dato['cantidad'];
        }

       
        $chart = $chartBuilder->createChart(Chart::TYPE_PIE);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data' => $cantidades,
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                ],
            ],
        ]);

        return $this->render('siniestro_detalle/reportes_victima_autor.html.twig', [
            'chart' => $chart,
        ]);
    }

    #[Route('siniestro_detalle/reportes/tipo_vehiculo', name: 'siniestro_detalle_reportes_tipo_vehiculo')]
    public function reportesTipoVehiculo(ChartBuilderInterface $chartBuilder, SiniestroDetalleRepository $repo): Response 
    {
        $datos = $repo->contarPorTipoVehiculo();

        foreach ($datos as $dato) {
            $labels[] = $dato['tipo'];
            $cantidades[] = $dato['cantidad'];
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Cantidad de Vehículos',
                    'data' => $cantidades,
                    'backgroundColor' => '#4BC0C0',
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestMin' => 0,
                    'suggestMax' => 100,
                ],
            ],
        ]);
        return $this->render('siniestro_detalle/reportes_tipo_vehiculo.html.twig', [
            'chart' => $chart,
        ]);
    }

}
