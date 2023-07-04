<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrierungController extends AbstractController
{
    #[Route('/reg', name: 'app_reg')]
    public function reg(Request $request, UserPasswordHasherInterface $passEncoder, ValidatorInterface $validator): Response
    {

        $regform = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => 'Mitarbeiter'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Passwort'],
                'second_options' => ['label' => 'Passwort wiederholen'],
            ])

            ->add('registrieren', SubmitType::class)
            ->getForm();

        $regform->handleRequest($request);

        if ($regform->isSubmitted()) {
            $eingabe = $regform->getData();

            $user = new User();
            $user->setUsername($eingabe['username']);

            $user->setPassword(
                $passEncoder->hashPassword($user, $eingabe['password'])
            );

            // check if password is powned
            $user->setRawPassword($eingabe['password']);

            $errors = $validator->validate($user);
            if (count($errors) > 0) {

                return $this->render('registrierung/index.html.twig', [
                    'regform' => $regform->createView(),
                    'errors' => $errors
                ]);
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('app_home'));
        }

        return $this->render('registrierung/index.html.twig', [
            'regform' => $regform->createView(),
            'errors' => null
        ]);
    }
}
