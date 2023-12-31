<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gericht', name: 'app_gericht.')]
class GerichtController extends AbstractController
{

    #[Route('/', name: 'app_bearbeiten')]
    public function index(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findAll();

        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte,
        ]);
    }

    #[Route('/anlegen', name: 'app_anlegen')]
    public function anlegen(Request $request)
    {
        $gericht = new Gericht();

        //Formular
        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $bild = $request->files->get('gericht')['bild'];

            if ($bild) {
                $dateiname = md5(uniqid()) . '.' . $bild->guessClientExtension();
            }

            $bild->move(
                $this->getParameter('bilder_ordner'),
                $dateiname
            );

            $gericht->setBild($dateiname);
            $em->persist($gericht);
            $em->flush();

            return $this->redirect($this->generateUrl('app_gericht.app_bearbeiten'));
        }

        //Response
        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView(),
        ]);
    }

    #[Route('/entfernen/{id}', name: 'app_entfernen')]
    public function entfernen($id, GerichtRepository $gr)
    {
        $em = $this->getDoctrine()->getManager();
        $gericht = $gr->find($id);

        $bild = $gericht->getBild();
        unlink($this->getParameter('bilder_ordner') . '/' . $bild);

        $em->remove($gericht);
        $em->flush();

        //message
        $this->addFlash('erfolg', 'Gericht wurde erfolgreich entfernt');

        return $this->redirect($this->generateUrl('app_gericht.app_bearbeiten'));
    }

    #[Route('/anzeigen/{id}', name: 'app_anzeigen')]
    public function anzeigen(Gericht $gericht)
    {
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht
        ]);
    }

    #[Route('/preis/{id}', name: 'app_preis')]
    public function preis($id, GerichtRepository $gerichtRepository)
    {
        $gericht = $gerichtRepository->find5Euro($id);

        dump($gericht);
    }
}
