<?php

namespace App\Controller;

use App\Entity\Postule;
use App\Entity\ProjetFinEtude;
use App\Entity\Salle;
use App\Entity\User;
use App\Form\PostuleType;
use App\Form\ReasonType;
use App\Repository\PostuleRepository;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormError;
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
    public function postule(ProjetFinEtude $pfe, Request $request): Response
    {
        $etudiantConnecte = $this->getUser();
        /*dump($etudiantConnecte);
        dump($etudiantConnecte->getPostules());
        foreach ($etudiantConnecte->getPostules() as $p) {
           dump($p);
        }*/
        if(count($etudiantConnecte->getPostules())>0){
            $this->addFlash('info', 'Vous etes deja postulé');
            return $this->redirectToRoute('projet_fin_etude_index');
        }
        $postule = new Postule();
        $postule->setStudent($etudiantConnecte);
        $postule->setPfe($pfe);
        $postule->setPostuledAt(new \DateTime());
        $postule->setIsAccepted(false);
        $postule->setReason(null);
        //dd($postule);
        $form = $this->createForm(PostuleType::class, $postule);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tested = $postule->getBinome();
            $postuleChecked = $this->getDoctrine()->getRepository(Postule::class)->findOneBy(['student'=>$tested]);
            if($postuleChecked){
                $form->get('binome')->addError(new FormError('Choisir un autre binome cet etudiant est deja postulé pour un projet'));
                return null;
            }
            $this->getDoctrine()->getManager()->persist($postule);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app');
        }
        return $this->render('app/postuler.html.twig',['form'=>$form->createView()]);
        die();
        /*$user = $this->getUser();
        $demande = $this->getDoctrine()->getRepository(Postule::class)->findOneBy(['pfe'=>$pfe,'student'=>$user]);
        if($demande){
            $this->addFlash('info', "vous avez postuler dans un projet");
            return $this->redirectToRoute('projet_fin_etude_index');
        }
        $postule = new Postule();
        $postule->setIsAccepted(false)
                ->setPfe($pfe)
                ->setStudent($user)
                ->setPostuledAt(new \DateTime());
                //dd($postule);
        $this->getDoctrine()->getManager()->persist($postule);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app');*/
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
        $postule->setIsAccepted(true);
        $postule->getPfe()->setIsAffected(true);
        $student = $postule->getStudent();
        //$allPostules = $this->getDoctrine()->getRepository(Postule::class)->findBy(['pfe'=>$pfe,'student'=>$student]);
        //dd($allPostules);
        $allPostules = $this->getDoctrine()->getRepository(Postule::class)->findBy(['student'=>$student]);
        foreach($allPostules as $p){
            if($p->getId() == $postule->getId()){
                continue;
            }else{
                $this->getDoctrine()->getManager()->remove($p);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        $this->getDoctrine()->getManager()->persist($postule);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app');
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
        $user = $this->getUser();
        $myEncadrements = [];
        foreach($user->getProjetFinEtudes() as $projet){
            $postuledProjects = $projet->getPostules();
            foreach($postuledProjects as $postuled){
                if($postuled->getIsAccepted()){
                    array_push($myEncadrements, $postuled);
                }
            }
        }
        return $this->render('app/encadrements.html.twig',['encadrements'=>$myEncadrements]);

    }
/**
     * @Route("/validate/pfe/{id}", name="validate_pfe")
     */
    public function validate(ProjetFinEtude $pfe, Request $request){
        $form = $this->createFormBuilder(null)
        ->add('salle', EntityType::class, [
            'attr'=>['class'=>'form-control'],
            'class'=>Salle::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->where('s.isDispo = :val')->setParameter('val',true)
                    ;
            }
            ])
        ->add('rapporteur', EntityType::class, [
            'attr'=>['class'=>'form-control'],
            'class'=>User::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.role != :val')->setParameter('val',"ROLE_AGENT")
                    ->andWhere('u.role != :val2')->setParameter('val2',"ROLE_STUDENT")
                    /*->andWhere('u != :p')->setParameter('p',$pfe->getEnseignant())*/;
            }
            ])
        ->add('president', EntityType::class, [
                'attr'=>['class'=>'form-control'],
                'class'=>User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.role != :val')->setParameter('val',"ROLE_AGENT")
                        ->andWhere('u.role != :val2')->setParameter('val2',"ROLE_STUDENT");
                }
            ])
            ->add('dateSoutenance', DateTimeType::class,['attr'=>['class'=>'form-control'],'widget' => 'single_text'])
            ->getForm()
        ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $salle = $data['salle'];
            $repertor = $data['rapporteur'];
            $president = $data['president'];
            $dateSoutenance = $data['dateSoutenance'];
            $pfe->setIsConfirmedAdmin(true)
                ->setPresident($president)
                ->setReporter($repertor)
                ->setDateSoutenance($dateSoutenance)
                ->setSalle($salle)
                ;
            $salle->setIsDispo(false);
            $this->getDoctrine()->getManager()->persist($salle);
            $this->getDoctrine()->getManager()->persist($pfe);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app');
        }
        return $this->render('app/validate-pfe.html.twig', ['form'=>$form->createView(),'projet'=>$pfe]);

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
        return $this->render('app/reason.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/my-project", name="my_project")
     */
    public function myProject(){
        $me = $this->getUser();
        $myproject = $this->getDoctrine()->getRepository(Postule::class)->findOneBy(['student'=>$me,'isAccepted'=>true]);

        return $this->render('app/my-project.html.twig', ['project'=>$myproject]);
    }

    /**
     * @Route("/detail/pfe/{id}", name="pfe_detail")
     */
    public function detail(Postule $pfe){
        return $this->render('app/detail-pfe.html.twig', ['postule'=>$pfe]);
    }

    /**
     * @Route("/refused_demands", name="get_refused_demands")
     */
    public function getRefusedDemands(PostuleRepository $postuleRepo){
        $user = $this->getUser();
        return $this->render('demandes/refused.html.twig',['demandes'=>$postuleRepo->getRefusedPostules($user)]);
    }


}
