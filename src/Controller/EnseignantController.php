<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/enseignant")
 */
class EnseignantController extends AbstractController
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * @Route("/", name="enseignant_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $connected = $this->getUser();
        //$dept = $this->
        if($connected->getRole() == "ROLE_AGENT"){
            $users = $userRepository->findBy(['role'=>"ROLE_CHEF"]);
        }else{
            $users = $userRepository->findBy(['role'=>"ROLE_TEACHER"]);
        }
        return $this->render('enseignant/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="enseignant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $connected = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->encoder->encodePassword($user, $user->getCin()));
            /*if($connected->getRole() == "ROLE_AGENT"){

                $user->setRole("ROLE_CHEF");
            }else{
                $user->setRole("ROLE_TEACHER");
            }*/
            $user->setRole("ROLE_TEACHER");
            $user->setIsChef(false);
            $entityManager = $this->getDoctrine()->getManager();
            $user->setEmail($user->getCin());
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('enseignant_index');
        }

        return $this->render('enseignant/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignant_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('enseignant/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="enseignant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignant_index');
        }

        return $this->render('enseignant/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignant_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enseignant_index');
    }

     /**
     * @Route("/delete/teacher/{id}", name="delete_teacher")
     */
    public function deleteStudent(User $teacher){
        $this->getDoctrine()->getManager()->remove($teacher);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success',"suppression terminée");
        return $this->redirectToRoute('enseignant_index');
    }
}
