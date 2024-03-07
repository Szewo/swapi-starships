<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Starship;
use App\Exception\ApplicationException;
use App\Service\SwapiFilterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(SwapiFilterInterface $swapiFilterService): Response
    {
        try {
            $starships = $swapiFilterService->getFilteredStarships();
        } catch (ApplicationException) {
            $starships = [];
        } finally {
            return $this->render(
                view: 'home/home.html.twig',
                parameters:
                [
                    'starships' => $starships,
                ]
            );
        }
    }

    #[Route('/save', name: 'save', methods: 'POST')]
    public function save(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $starship = $serializer->deserialize(
            data: $request->getPayload()->get('starship'),
            type: Starship::class,
            format: 'json'
        );
        $entityManager->persist($starship);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
