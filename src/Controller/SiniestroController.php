<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Form\SiniestroType;
use App\Entity\SiniestroDetalle;
use App\Repository\SiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilder;

final class SiniestroController extends AbstractController
{
    #[Route('/siniestro', name: 'siniestro_index', methods: ['GET'])]
    public function index(Request $request, SiniestroRepository $siniestroRepository): Response
    {
        $fecha = $request->query->get('fecha');
        $siniestros = $siniestroRepository->findByFecha($fecha);

        return $this->render('siniestro/index.html.twig', [
            'siniestros' => $siniestros,
            'fecha' => $fecha,
        ]);
    }



    #[Route('/siniestro/new', name: 'siniestro_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $siniestro = new Siniestro();
        $siniestro->addSiniestroDetalle(new SiniestroDetalle()); 
        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestro);
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('siniestro/new.html.twig', [
            'form' => $form->createView(),
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}', name: 'siniestro_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Siniestro $siniestro): Response {
        return $this->render('siniestro/show.html.twig', [
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/siniestro/{id}/detalles', name: 'siniestro_detalles')]
    public function showDetalles(Siniestro $siniestro): Response {
        return $this->render('siniestro/show_detalles.html.twig', [
            'siniestro' => $siniestro,
            'detalles' => $siniestro->getSiniestroDetalles(),
        ]);
    }

    #[Route('/siniestro/edit/{id}', name: 'siniestro_edit')]
    public function edit(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('siniestro/edit.html.twig', [
            'form' => $form->createView(),
            'siniestro' => $siniestro,
        ]);

    }

    #[Route('/siniestro/delete/{id}', name: 'siniestro_delete', methods: ['POST'])]
    public function delete(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$siniestro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($siniestro);
            $entityManager->flush();
        }
        return $this->redirectToRoute('siniestro_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/siniestro/reportes/mes', name: 'siniestro_reportes_mes')]
    public function reportesMes(ChartBuilderInterface $chartBuilder, SiniestroRepository $repo): Response
    {
        $datos = $repo->obtenerCantidadPorMes();

        foreach($datos as $fila){
            $labels[] = $fila['mes'];
            $cantidades[] = $fila['cantidad'];
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            // ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Siniestros por Mes',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                    // [12, 19, 3, 5, 2, 3, 7, 8, 6, 4, 9, 11]
                    'data' => $cantidades,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestMin' => 0,
                    'suggestMax' => 100,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                ],
            ],
        ]);

        return $this->render('siniestro/reportes_mes.html.twig', [
            'chart' => $chart,
        ]);
    }

    #[Route('siniestro/reportes/anio', name: 'siniestro_reportes_anio')]
    public function reportesAnio(ChartBuilderInterface $chartBuilder, SiniestroRepository $repo): Response 
    {
        $datos = $repo->obtenerCantidadPorAnio();

        foreach($datos as $fila){
            $anios[] = $fila['anio'];
            $cantidades[] = $fila['cantidad'];
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            // ['2019', '2020', '2021', '2022', '2023', '2024']
            'labels' => $anios,
            'datasets' => [
                [
                    'label' => 'Siniestros por Año',
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'borderColor' => 'rgba(153, 102, 255, 1)',
                    'borderWidth' => 1,
                    //[150, 200, 180, 220, 250, 300]
                    'data' => $cantidades,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestMin' => 0,
                    'suggestMax' => 400,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                ],
            ],
        ]);

        return $this->render('siniestro/reportes_anio.html.twig', [
            'chart' => $chart,
        ]);
    }

}
