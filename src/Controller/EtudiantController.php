<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'users' => $userRepository->findBy(['role'=>"ROLE_STUDENT"]),
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $user->setRole("ROLE_STUDENT");
        $pass = "secret#123";
        $user->setPassword($this->encoder->encodePassword($user, $pass));
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setRole("ROLE_STUDENT");
            $user->setIsChef(false);
            //$pass = "secret#123";
            $user->setPassword($this->encoder->encodePassword($user, $user->getCin()));
            $user->setEmail($user->getCin());
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }

    /**
     * @Route("/delete/student/{id}", name="delete_student")
     */
    public function deleteStudent(User $student){
        $this->getDoctrine()->getManager()->remove($student);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success',"suppression terminée");
        return $this->redirectToRoute('etudiant_index');
    }
}
