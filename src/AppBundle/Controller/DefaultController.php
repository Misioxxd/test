<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProgrammerType;
use AppBundle\Form\Type\RelationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @param Request $request
     * @Route("/b", name="InsertData")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function anotherAction(Request $request)
    {


        $form = $this->createForm(RelationType::class);
        $form ->add('save',SubmitType::class,array(
            'label'=>"wyslij "
        ));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirect($request->getUri());

        }
        return $this->render('default/add.html.twig',[
            'form1'=>$form->createView()
        ]);

    }

    /**
     *
     * @Route ("/a" ,name="showData")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDataAction()
    {
        $showData = $this->getDoctrine()->getManager()
            ->createQueryBuilder()
            ->from('AppBundle:Test','t')
            ->innerjoin('AppBundle:Work','w','WITH','t.work=w.id')
            ->select('t.id,t.name,t.surname,w.name as workname')
            ->orderBy('t.id','asc')
            ->getQuery()
            ->getResult();
        return $this->render(':default:show.html.twig',[
            'data'=>$showData
        ]);
    }



    /**
     *
     * @Route ("/home", name="HomePage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction()
    {
        return $this->render(':default:main.html.twig');
    }
    /**
     *
     * @Route ("/edit/{id}", name="editPage")
     * **/
//    public function editAction($id) {
//
//    }

}
