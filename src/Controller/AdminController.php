<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

/**
 * @Route("/admin")
 * @param Request $request
 * @return Response
 * */

public function new(){
    return new Response('Admin Sayfasi');
}


}