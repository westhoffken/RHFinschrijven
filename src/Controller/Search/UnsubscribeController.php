<?php


namespace App\Controller\Search;

use App\Manager\SearchQueryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UnsubscribeController extends AbstractController
{

    /**
     * @var SearchQueryManager
     */
    private $manager;

    public function __construct(SearchQueryManager $manager)
    {

        $this->manager = $manager;
    }

    /**
     * @Route("/uitschrijven/{email}", name="unsubscribe")
     * @Route("/uitschrijven/{email}/confirm", name="unsubscribe_confirm")
     */
    public function removeAction(Request $request, string $email)
    {
        $route = $request->attributes->get('_route');
        if($route === 'unsubscribe_confirm'){
//            $this->manager->r
        }
        return $this->render('search/unsubscribe.html.twig', [
            'email' => $email
        ]);
    }
}
