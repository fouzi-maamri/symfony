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
      //cette function pour le route add5
    }

    public function biggerthan(){
      $repo= $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findBiggerSizeThan(5.5);
      return $this->render('DQL/DQL.html.twig' ,['results' => $results]);
      //cette function pour la route add6 // lien /biggerthan/
      //cette function permi laffichage tous les telephone >= 5.5
    }

    public function searchMarque(Request $request , $marque){
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findmarque($request->attributes->get('marque'));
      return $this->render('DQL/searchMarque.html.twig',["results" => $results]);
      //cette fonction pour la route add7
    }

    public function searchId(Request $request , $id){
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findBiggerSizeThanQb($request->attributes->get('id'));
      //$requist hiya likhatkhdem lina ID
      return $this->render('DQL/searchId.html.twig',["results" => $results]);
      //cette  function responsable sur taille de telephone (le nom de id = c'est le nom de taille ) ( t affiche lina les telephone l superiere mn 5 )
      //cette function pour la route QueryBuilder
    }

    /*
    public function searchMarqueType(Request $request , $marque , $type){
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findBiggerSizeThanQb($request->attributes->get('id'));
      //$requist hiya likhatkhdem lina ID
      return $this->render('DQL/searchId.html.twig',["results" => $results]);
      //cette  function responsable sur id avec la taille de telephone ( t affiche lina les telephone l superiere mn 5 )
    }
    */

    public function trouveTelephone(Request $request , $marque , $type){
      $repo = $this->getDoctrine()->getRepository(Telephone::class);
      $results= $repo->findTelephone($request->attributes->get('marque') , $request->attributes->get('type'));
      //$requist hiya likhatkhdem lina ID
      return $this->render('DQL/trouveTelephone.html.twig',["results" => $results]);
      //cette function pour la route QueryBuilder2
      // soit on tapper 0 sur la marque soit 0 dans le tyep ilaffiche quelque chose
    }

}
