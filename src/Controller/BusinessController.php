<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BusinessController extends AbstractController
{
    #[Route('/business', name: 'app_business')]
    public function index(): Response
    {
        return $this->render('business/index.html.twig');
    }
}
