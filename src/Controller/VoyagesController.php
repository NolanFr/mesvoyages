<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;
use Symfony\Component\HttpFoundation\Request;
/**
 * Description of VoyagesController
 *
 * @author nolan
 */
class VoyagesController extends AbstractController{
    /**
     * @Route("/voyages", name="voyages")
     * @return Response
     */
    
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
        
    }
       /**
    * 
    *  @var VisiteRepository
    */
   private $repository;

        /**
      * 
      * @param VisiteRepository $repository
      */
    public function __construct(VisiteRepository $repository){
         $this->repository = $repository;
     }
     
    /*
     * @Route("/voyages/tri/{champ}/{ordre}", name="voyages.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
     
    public function sort($champ, $ordre): Response {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]); 
        
    }
    
    public function findAllEqual($champ, Request $request): Response {
      $valeur = $request->get("recherche");
      $visites = $this->repository->findEqualValue($champ, $valeur);
      return $this->render("pages/voyages.html.twig", [
          'visites' => $visites
      ]);
  }
   
    public function showOne ($id): Response{
        $visite = $this->repository->find($id);
        return $this->render("pages/voyage.html.twig",[
            'visite' => $visite
        ]);
    }
}


