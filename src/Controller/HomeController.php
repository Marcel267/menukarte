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
        $num = count($gerichte) === 1 ? 1 : 2;

        if ($gerichte) {
            $zufall = array_rand($gerichte, $num);
            $gerichte = array_intersect_key($gerichte, array_flip((array)$zufall));
        }



        return $this->render('home/index.html.twig', [
            'random_gerichte' => $gerichte
        ]);
    }
}
