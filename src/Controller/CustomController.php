<?php

namespace App\Controller;

use App\Entity\Postule;
use App\Entity\ProjetFinEtude;
use App\Form\ReasonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomController extends AbstractController
{
    /**
     * @Route("/postule/{id}", name="apply_to_pfe")
     */
    public function postule(ProjetFinEtude $pfe): Response
    {   
       
        $user = $this->getUser();
        
        $postule = new Postule();
        $postule->setIsAccepted(false)
                ->setPfe($pfe)
                ->setStudent($user)
                ->setPostuledAt(new \DateTime());
                //dd($postule);        
        $this->getDoctrine()->getManager()->persist($postule);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app');
    }

    /**
     * @Route("/demandes", name="get_demandes", methods={"GET"})
     */
    public function getDemandes(){
        $user = $this->getUser();
        $myPropositions = $user->getProjetFinEtudes();
        $dmds = [];
        foreach($myPropositions as $prop){
            $demandes = $this->getDoctrine()->getRepository(Postule::class)->findBy(['pfe'=>$prop,'reason'=>null]);
            foreach($demandes as $d){
                array_push($dmds, $d);
            }
        }
        return $this->render('demandes/index.html.twig',['demandes'=>$dmds]);
        //$demandes = $this->getDoctrine()->getRepository(Postule::class)->findBy([])
    }

    /**
     * @Route("/accept/{id}", name="accept_demand")
     */
    public function accept(Postule $postule){
        dd($postule);
    }

    /*
     * @Route("/refuse/{id}", name="refuse_demand")
     
    public function refuse(Postule $postule){
        dd($postule);
    }*/

    /**
     * @Route("/encadrements", name="get_encadrements", methods={"GET"})
     */
    public function getEncadrements(){
        $encadrements = $this->getDoctrine()->getRepository(ProjetFinEtude::class)->findBy([
            'enseignant'=>$this->getUser(),
            'isAffected'=>true
        ]);
        return $this->render('app/encadrements.html.twig',['encadrements'=>$encadrements]);
       
    }

    /**
     * @Route("/given_reason/{id}", name="give_reason_refusal")
     */
    public function giveReason(Postule $postule, Request $request){

        $form = $this->createForm(ReasonType::class, $postule);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $postule->setIsAccepted(false);
            $this->getDoctrine()->getManager()->persist($postule);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('get_demandes');
        }
        return $this->render('app/reason.html.twig');
    }
}
