<?php

namespace Nada\AutoEcoleBundle\Controller;

use DataBundle\Entity\Quiz;
use Nada\AutoEcoleBundle\Form\AjoutQuizType;
use Nada\AutoEcoleBundle\Form\ModifQuizType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function showQuizAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $qz=$em->getRepository("DataBundle:Quiz")->findBy(array('test'=>$id)) ;

        return $this->render("NadaAutoEcoleBundle:Quiz:ListQuiz.html.twig", array("qz" =>$qz)) ;



    }



    public function AjoutQuizAction(Request $request) {
        $quiz=new Quiz() ;
        $Form =$this->createForm(AjoutQuizType::class, $quiz) ;
        $Form->handleRequest($request) ;
        if($Form->isValid()) {
            $em=$this->getDoctrine()->getManager() ;
            $em->persist($quiz) ;
            $em->flush() ;
            return $this->redirectToRoute("nada_auto_ecole_Test") ;
        }

        return $this->render("NadaAutoEcoleBundle:Quiz:AjoutQuiz.html.twig", array('formAjoutQuiz'=> $Form->createView())) ;

    }


    public function SuppQuizAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $quiz= $em->getRepository("DataBundle:Quiz")->findOneBy(array('idQuiz'=>$id)) ;
        $em->remove($quiz);
        $em->flush();

        return $this->redirectToRoute("nada_auto_ecole_Test") ;
    }


    public function ModifQuizAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager() ;
        $quiz= $em->getRepository("DataBundle:Quiz")->findOneBy(array('idQuiz'=>$id )) ;

        $Form =$this->createForm(ModifQuizType::class, $quiz) ;
        $Form->handleRequest($request) ;
        if($Form->isValid()) {
            $em=$this->getDoctrine()->getManager() ;
            $em->persist($quiz) ;
            $em->flush() ;

            return $this->redirectToRoute("nada_auto_ecole_Test")
                ; }
        return $this->render('NadaAutoEcoleBundle:Quiz:ModifQuiz.html.twig',
            array('formModifQuiz'=>$Form->createView())) ;

    }
}
