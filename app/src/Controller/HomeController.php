<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ApplicationException;
use App\Service\SwapiFilterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/')]
    public function home(SwapiFilterInterface $swapiFilterService): Response
    {
        try {
            $starships = $swapiFilterService->getFilteredStarships();
        } catch (ApplicationException) {
            $starships = [];
        } finally {
            return $this->render(
                view:'home/home.html.twig',
                parameters: ['starships' => $starships]
            );
        }
    }

}
