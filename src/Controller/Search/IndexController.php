<?php


namespace App\Controller\Search;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/search" , name="search_querys")
     */
    public function indexAction()
    {

        return $this->render('search/index.html.twig', []);
    }

}
