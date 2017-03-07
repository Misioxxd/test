<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProgrammerType;
use AppBundle\Form\Type\RelationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
//    /**
//     * @Route("/", name="homepage")
//     */
//    public function indexAction(Request $request)
//    {
//        $posts=$this->getDoctrine()
//            ->getManager()
//            ->createQueryBuilder()
//            ->from("AppBundle:Post",'p')
//            ->select('p')
//            ->getQuery()
//            ->getResult();
//        return $this->render('default/index.html.twig',array(
//            'posts'=>$posts
//            )
//        );
//    }

    /**
     *
     * @Route("/a")
     */
    public function addAction(Request $request)
    {
     $form = $this->createForm(ProgrammerType::class);
     $form->handleRequest($request);
     if($form->isSubmitted() && $form->isValid())
     {
         $em = $this->getDoctrine()->getManager();
         $product = $form->getData();
         $em->persist($product);
         $em->flush();
     }
     return $this->render('default/index.html.twig',[
         'form'=>$form->createView()
     ]);
    }

    /**
     * @param Request $request
     * @Route("/b")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function anotherAction(Request $request)
    {
        $form = $this->createForm(RelationType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
        }
        return $this->render('default/index.html.twig',[
            'form1'=>$form->createView()
        ]);

    }
}
