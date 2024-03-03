<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/activ')]
    public function activ(): Response
    {
        return $this->render('activ.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/etab')]
    public function etab(): Response
    {
        return $this->render('etab.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/prod')]
    public function prod(): Response
    {
        return $this->render('prod.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/recla')]
    public function recla(): Response
    {
        return $this->render('recla.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/profi')]
    public function profi(): Response
    {
        return $this->render('profi.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/reser')]
    public function reser(): Response
    {
        return $this->render('reser.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/comma')]
    public function comma(): Response
    {
        return $this->render('comma.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/admin')]
    public function admin(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    
}
