<?php

namespace App\Controller;

use App\Entity\ProjetFinEtude;
use App\Form\ProjetFinEtudeType;
use App\Repository\PostuleRepository;
use App\Repository\ProjetFinEtudeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projet/fin/etude")
 */
class ProjetFinEtudeController extends AbstractController
{
    /**
     * @Route("/", name="projet_fin_etude_index", methods={"GET"})
     */
    public function index(ProjetFinEtudeRepository $projetFinEtudeRepository): Response
    {

        $user = $this->getUser();
        if($user->getRole() === "ROLE_STUDENT")
        {
            
            /*if($user->getPostules()){
                $projets = [];
                foreach($user->getPostules() as $myPostule){
                    foreach($projetFinEtudeRepository->findAll() as $p){
                        if($p == $myPostule->getPfe()){
                            continue;
                        }else{
                            array_push($projets, $p);
                        }
                    }
                }
                return $this->render('projet_fin_etude/index.html.twig', [
                    'projet_fin_etudes' => $projets,
                ]);
            }else{
                return $this->render('projet_fin_etude/index.html.twig', [
                    'projet_fin_etudes' => $projetFinEtudeRepository->findAll(),
                ]);
            }*/
           
        }
        
        return $this->render('projet_fin_etude/index.html.twig', [
            'projet_fin_etudes' => $projetFinEtudeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/pfe/administration", name="projet_fin_etude_administration", methods={"GET"})
     */
    public function pfes(PostuleRepository $postuleRepo): Response
    {
        return $this->render('projet_fin_etude/pfes.html.twig', [
            'projet_fin_etudes' => $postuleRepo->findBy(['isAccepted'=>true]),
        ]);
    }

    /**
     * @Route("/new", name="projet_fin_etude_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projetFinEtude = new ProjetFinEtude();
        $projetFinEtude->setPublishedAt(new \DateTime());
        $projetFinEtude->setIsAffected(false);
        $projetFinEtude->setIsConfirmedAdmin(false);
        $projetFinEtude->setEnseignant($this->getUser());
        $form = $this->createForm(ProjetFinEtudeType::class, $projetFinEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projetFinEtude);
            $entityManager->flush();

            return $this->redirectToRoute('projet_fin_etude_index');
        }

        return $this->render('projet_fin_etude/new.html.twig', [
            'projet_fin_etude' => $projetFinEtude,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_fin_etude_show", methods={"GET"})
     */
    public function show(ProjetFinEtude $projetFinEtude): Response
    {
        return $this->render('projet_fin_etude/show.html.twig', [
            'projet_fin_etude' => $projetFinEtude,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_fin_etude_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProjetFinEtude $projetFinEtude): Response
    {
        $form = $this->createForm(ProjetFinEtudeType::class, $projetFinEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_fin_etude_index');
        }

        return $this->render('projet_fin_etude/edit.html.twig', [
            'projet_fin_etude' => $projetFinEtude,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_fin_etude_delete", methods={"POST"})
     */
    public function delete(Request $request, ProjetFinEtude $projetFinEtude): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projetFinEtude->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projetFinEtude);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_fin_etude_index');
    }


}
