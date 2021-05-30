<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     */
    public function index(): Response
    {
        $nbr_etudiants = count($this->getDoctrine()->getRepository(User::class)->findBy(['role'=>"ROLE_STUDENT"]));
        $nbr_teachers = count($this->getDoctrine()->getRepository(User::class)->findBy(['role'=>"ROLE_TEACHER"]));
        /*$nbr_etudiants = count($this->getDoctrine()->getRepository(User::class)->findBy(['role'=>"ROLE_"]));
        $nbr_etudiants = count($this->getDoctrine()->getRepository(User::class)->findBy(['role'=>"ROLE_STUDENT"]));
        */
        return $this->render('app/index.html.twig', [
            'students' => $nbr_etudiants,
            'teachers' => $nbr_teachers
        ]);
    }


}
