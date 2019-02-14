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
        //pour la modification premier
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

    //************************** Formulaire *********************
    public function new(Request $request)
      {
          $tel = new Telephone();

          $form = $this->createForm(TelephoneType::class, $tel);

          // nous récupérons ici les informations du formulaire validée
          // c'est-à-dire l'équivalent du $_POST
          // ... et ce, grâce à l'objet $request
          // qui représente les informations sur la requête HTTP reçue (voir l'explication après le code)
          $form->handleRequest($request);

          // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
          if ($form->isSubmitted() && $form->isValid()) {
              // nous enregistrons directement l'objet $tel !
              // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
              $em = $this->getDoctrine()->getManager();
              $em->persist($tel);
              $em->flush();

              // nous redirigeons l'utilisateur vers la route /telephone/
              // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml
              // (il est peut-être différent pour vous, adaptez en conséquence)
              // extrèmement pratique : si nous devons changer l'url en elle-même,
              // nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
              return $this->redirectToRoute('telephone_index');
          }

          return $this->render('telephone/new.html.twig', array(
              'form' => $form->createView(),
          ));
          //route Formulaire
      }

      public function modify(){
        
        //pour la modification Formulaire
        //la route FormulaireModify
      }
}
