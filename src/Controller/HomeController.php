<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GerichtRepository $gr): Response
    {

        $gerichte = $gr->findAll();

        if ($gerichte) {
            $zufall = array_rand($gerichte, 2);
            $gerichte = [
                $gerichte[$zufall[0]],
                $gerichte[$zufall[1]]
            ];
        }


        return $this->render('home/index.html.twig', [
            'random_gerichte' => $gerichte
        ]);
    }
}
