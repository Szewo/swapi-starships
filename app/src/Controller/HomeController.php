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

    #[Route('/save', name: 'save')]
    public function save(Request $request, EntityManagerInterface $entityManager): Response
    {
        $starship = new Starship();
        $starship->setName($request->get('name'));
        $starship->setModel($request->get('model'));
        $starship->setStarshipClass($request->get('starshipClass'));
        $starship->setConsumables($request->get('consumables'));
        $starship->setCostInCredits($request->get('costInCredits'));
        $starship->setCrew($request->get('crew'));
        $starship->setPassengers($request->get('passengers'));
        $starship->setHyperdriveRating((float) $request->get('hyperdriveRating'));

        $entityManager->persist($starship);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

}
