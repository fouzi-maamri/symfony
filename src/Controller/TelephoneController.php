<?php

namespace App\Controller;
use App\Entity\Telephone;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TelephoneController extends AbstractController
{
    /**
     * @Route("/telephone", name="telephone")
     */
    public function index()
    {
        return $this->render('telephone/index.html.twig', [
            'controller_name' => 'TelephoneController',
        ]);
    }

    public function add(){
      $tel = new Telephone();
      $tel->setMarque('Nokia2');
      $tel->setType('88');
      $tel->setTaille(5.33);

      $em = $this->getDoctrine()->getManager();
      $em->persist($tel);
      $em->flush();
      return $this->render('telephone/tp.html.twig');
    }

    public function add2(Request $request, $marque, $type, $taille){
      $tel = new Telephone();
      $tel->setMarque($request->attributes->get('marque'));
      $tel->setType($request->attributes->get('type'));
      $tel->setTaille($request->attributes->get('taille'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($tel);
      $em->flush();
      return $this->render('telephone/tp.html.twig');
    }

    public function modifierTel(Request $request , $marque , $type , $taille , $id){
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Telephone::class)->find($request->attributes->get('id'));
        $repo->setMarque($request->attributes->get('marque'));
        $repo->setTaille($request->attributes->get('taille'));
        $repo->setType($request->attributes->get('type'));
        $em->flush();
        return $this->render("telephone/tp.html.twig");
    }

    public function suprimetel(Request $request , $id){
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Telephone::class)->find($request->attributes->get('id'));
        $em->remove($repo);
        $em->flush();
        return $this->render("telephone/tp.html.twig");
    }

    public function index2(Request $request){
      $em = $this->getDoctrine()->getManager();
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $telSamsung = $repo->findBy(["marque" => "Samsung"]);
      return $this->render("telephone/telephone.html.twig",["telSamsung" => $telSamsung]);
    }

    public function biggerthan(){
      $repo= $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findBiggerSizeThan(5.5);
      return $this->render('DQL/DQL.html.twig' ,['results' => $results]);
    }

    public function searchMarque(Request $request , $marque){
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findmarque($request->attributes->get('marque'));
      return $this->render('DQL/searchMarque.html.twig',["results" => $results]);
    }


}
