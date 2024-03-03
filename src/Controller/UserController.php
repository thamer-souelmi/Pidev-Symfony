<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/user')]
class UserController extends AbstractController
{
   
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        $usersRepository = $entityManager->getRepository(User::class);
        $user = $usersRepository->findByRoles('admin');
        return $this->render('user/tableau-de-bord.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user->setImage('1.jpg');

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                
                    $imageFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                

                $user->setImage($newFilename);
            }

            
            $hashedPassword = hash('sha1', $user->getPassword());
            $user->setMdp($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/inscri-utilisateur.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/détails-utilisateurs.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route('/new/back', name: 'app_user_newback', methods: ['GET', 'POST'])]
    public function newback(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user->setImage('1.jpg');

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                
                    $imageFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                

                $user->setImage($newFilename);
                
            }

            
            $hashedPassword = hash('sha1', $user->getPassword());
            $user->setMdp($hashedPassword);
            $user->setRole('admin');

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/inscri-admin.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user = $this->getUser(); 
        if ($form->isSubmitted() && $form->isValid()) {
           
            $formData = $form->getData();
               /** @var UploadedFile $imageFile */
               $imageFile = $form->get('image')->getData();
        
               if ($imageFile) {
                   $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                   $safeFilename = $slugger->slug($originalFilename);
                   $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                   try {
                       $imageFile->move(
                           $this->getParameter('img_directory'),
                           $newFilename
                       );
                   } catch (FileException $e) {
                   }
       
                    $user->setImage($newFilename);
               }

               $hashedPassword = hash('sha1', $user->getPassword());
               $user->setMdp($hashedPassword);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/modifier-utilisateur.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit/back', name: 'app_user_editback', methods: ['GET', 'POST'])]
    public function editback(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user = $this->getUser(); 
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
               /** @var UploadedFile $imageFile */
               $imageFile = $form->get('image')->getData();
        
               if ($imageFile) {
                   $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                   $safeFilename = $slugger->slug($originalFilename);
                   $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                   try {
                       $imageFile->move(
                           $this->getParameter('img_directory'),
                           $newFilename
                       );
                   } catch (FileException $e) {
                   }
       
                   $user->setImage($newFilename);
               }
               $user->setRole('admin');
               $hashedPassword = hash('sha1', $user->getPassword());
                $user->setMdp($hashedPassword);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('user/modifier-admin.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->get('security.token_storage')->setToken(null);
            $this->get('session')->invalidate();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/back/{id}', name: 'app_user_deleteback', methods: ['GET', 'POST'])]
    public function deleteb(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
