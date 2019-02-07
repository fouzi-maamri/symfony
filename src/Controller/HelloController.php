<?php

// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// notre controller doit forcément hériter de la classe Controller ("use" ci-dessus)
// Le nom de la classe doit être exactement le même que celui du fichier
class HelloController extends Controller
{

    public function index()
    {
        // on renvoie ici un texte simple. Une instance de Response doit toujours être renvoyée.
        $prenom ="Sylvain";
        $prenom1 = "fouzi";
        $prenom2 = "maamri";
        $age = 24;

        $tableau_prenoms = array($prenom,$prenom1,$prenom2);

        return $this->render('hello.html.twig', array(
          "tableau_prenoms" => $tableau_prenoms,
        ));
    }

    public function index_perso_prenom($prenom)
    {

          return $this->render('erreur.html.twig', array(
            "prenom" => $prenom,

          ));
    }


    public function index_perso_prenom_age($prenom,$age)
    {

          return $this->render('hello_perso_prenom_age.html.twig', array(
            "prenom1" => $prenom,
            "age" => $age,

          ));
    }


    public function functionanas(){
            $prenoms = ["anas","fouzi","karim"];
            $prenom = "masculin";
            $prenom2 = "fimunin";
            return $this->render('anas.html.twig',[
              "prenom" => $prenom , "prenom2" => $prenom2 ,
              "prenoms" => $prenoms
            ]);
    }

}
 ?>
