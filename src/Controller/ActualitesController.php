<?php

namespace App\Controller;

use App\Entity\Actualites;
use App\Entity\Categories;
use App\Entity\Commentaires;
use App\Entity\Users;
use App\Form\ActualitesType;
use App\Form\CommentairesType;
use App\Repository\ActualitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/actualites")
 */
class ActualitesController extends AbstractController
{
    /**
     * @Route("/", name="actualites_index", methods={"GET"})
     */
    public function index(ActualitesRepository $actualitesRepository): Response
    { $repository = $this->getDoctrine()->getRepository(Commentaires::class);
   
       $actualites = $actualitesRepository->findAll();

       /*
       foreach (  $actualites as $cle =>$actualite)
        {
               $commentaires  = $repository->findBy(['actu'=>$actualite->getId()]);
               foreach($commentaires as $cle=>$c){
                   $id = $c->getRetourcom()->getId();
                  $user =  $this->getDoctrine()->getRepository(Users::class)->find(['id'=>$id]);
                  $c->setRetourcom($user);
               }
             
              
                $actualite->setCommentaires($commentaires);
                       
        }
        ($actualites); */
        return $this->render('actualites/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }


    /**
     * @Route("/mesactu", name="actualites_mesactu", methods={"GET"})
     */
    public function mesactu(ActualitesRepository $actualitesRepository): Response
    {        
        $actualites = $actualitesRepository->findby(['iduser'=> $this->getUser()]);

        return $this->render('actualites/mesactu.html.twig', [
            'actualites' => $actualites,
        ]);
    }


    /**
     * @Route("/new", name="actualites_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $actualite = new Actualites();
        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image*/
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
         if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();    

                // Move the file to the directory where image are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $actualite->setImage($newFilename);
            }
           /* if ($image) {
                $fileUploader->upload($image);
             
         }   */ 
            
            $actualite->setIduser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('actualites_index');
        }

        return $this->render('actualites/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
        
        
    }

    /**
     * @Route("/{id}", name="actualites_show", methods={"GET","POST"})
     */
    public function show(Request $request , Actualites $actualite): Response
    {

        
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $commentaire->setRetourcom($this->getUser());
            $commentaire->setActu($actualite); 
            $entityManager->persist($commentaire);
            $entityManager->flush();

          return $this->redirectToRoute('actualites_show', ["id" =>$actualite->getId() ]); 
        

        }
        return $this->render('actualites/show.html.twig', [
            'actualite' => $actualite,
            'commentaire' => $commentaire,
            'commentaireForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actualites_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actualites $actualite, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where image are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $actualite->setImage($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actualites_index');
        }

        return $this->render('actualites/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actualites_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Actualites $actualite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actualites_index');
    }

     /**
     * @Route("/actualites/{id}", name="actualites_read", methods={"GET"})
     * 
     * @return void
     */
    public function read(Actualites $actualites)
    {
        ($actualites);
    }

}
