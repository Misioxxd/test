<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProgrammerType;
use AppBundle\Form\Type\RelationType;
use Doctrine\DBAL\Types\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @param Request $request
     * @Route("/b", name="InsertData")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
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
            $this->get('session')->getFlashBag()->add('success', 'Dodano pracownika');
            $url = $this->generateUrl('showData');

            return $this->redirect($url);

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
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/edit/{id}", name="Edit")
     */
    public function editAction($id,Request $request) {
        $edit =$this->getDoctrine()->getManager()->getRepository('AppBundle:Test')
            ->findOneBy(array('id'=>$id));
        $form = $this->createForm(RelationType::class,$edit);
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
            $this->get("session")->getFlashBag()->add("success","Edycja została ukończona pomyślnie");

            return $this->redirect('/a');
        }
        return $this->render('default/add.html.twig',[
            'form1'=>$form->createView()
        ]);

    }

    /**
     * @Route ("/d/{id}", name="Delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $adminentities = $em->getRepository('AppBundle:Test')->find($id);
        $em->remove($adminentities);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success','Usuwanie przebiegło pomyślnie');
        return $this->redirect("/a");
    }
}
