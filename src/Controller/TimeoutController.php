<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TimeoutController extends AbstractController
{
    /**
     * @Route("/timeout", name="timeout")
     */
    public function index()
    {
        return $this->render('timeout/index.html.twig', [
            'controller_name' => 'TimeoutController',
        ]);
    }
}
