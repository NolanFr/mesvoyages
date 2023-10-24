<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VisiteRepository;
use App\Entity\Visite;
use App\Form\VisiteType;
use Doctrine\ORM\EntityManagerInterface;
/**
 * Description of VoyagesController
 *
 * @author nolan
 */
class AdminVoyagesController extends AbstractController{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("admin/admin.voyages.html.twig", [
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
   
    public function showOne($id): Response{
        $visite = $this->repository->find($id);
        return $this->render("pages/voyage.html.twig",[
            'visite' => $visite
        ]);
    }
    
    public function suppr(int $id) : Response {
    $visite = $this->repository->find($id);
    $this->repository->remove($visite, true);
    return $this->redirectToRoute('admin');
}
    public function edit($id, Request $request):Response{
        $visite = $this->repository->find($id);
        $formVisite = $this->createForm(VisiteType::class, $visite);
        
        $formVisite->handleRequest($request);
        if($formVisite->isSubmitted() && $formVisite->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visite); // Ajoute l'entité à la gestion
            $entityManager->flush(); // Sauvegarde les changements dans la base de données

        }
        
        return $this->render("admin/admin.voyage.edit.html.twig",[
            'visite' => $visite,
            'formvisite' => $formVisite->createView()
            
        ]);
    }
        
    public function ajout(Request $request): Response {
    $visite = new Visite();
    $formVisite = $this->createForm(VisiteType::class, $visite);

    $formVisite->handleRequest($request);
    if ($formVisite->isSubmitted() && $formVisite->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($visite); // Ajoute l'entité à la gestion
        $entityManager->flush(); // Sauvegarde les changements dans la base de données

        return $this->redirectToRoute('admin');
    }

    return $this->render("admin/admin.voyage.ajout.html.twig", [
        'visite' => $visite,
        'formvisite' => $formVisite->createView()
    ]);
}
        
}

