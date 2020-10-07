<?php


namespace App\Controller\Search;


use App\Entity\SearchQuery;
use App\Entity\Size;
use App\Mail\ConfirmationMail;
use App\Manager\SearchQueryManager;
use App\Manager\SizeManager;
use App\Service\Search\FindForSearchQueryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AddSearchQueryController extends AbstractController
{

    /**
     * @var SearchQueryManager
     */
    private $productManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var SizeManager
     */
    private $sizeManager;
    /**
     * @var ConfirmationMail
     */
    private $confirmationMail;
    /**
     * @var FindForSearchQueryService
     */
    private $findForSearchQueryService;

    public function __construct(
        SearchQueryManager $productManager,
        SizeManager $sizeManager,
        ConfirmationMail $confirmationMail,
        FindForSearchQueryService $findForSearchQueryService
    ) {
        $this->productManager = $productManager;
        $this->sizeManager = $sizeManager;
        $this->confirmationMail = $confirmationMail;
        $this->findForSearchQueryService = $findForSearchQueryService;
    }

    /**
     * @Route("/inschrijven", name="new_search_query")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {

        $searchQuery = new SearchQuery();
        $searchQuery->setSize(new Size());

        if ($request->getMethod() === 'POST' && $request->getRequestUri() === '/inschrijven') {
//            dump($request->request->all());
            $searchQuery = $this->productManager->makeEntity($request->request->all(), $searchQuery);
//            dump($searchQuery);

            if ($this->productManager->saveSearchQuery($searchQuery, true)) {
                return $this->redirectToRoute('confirm_search_query', ['searchQuery' => $searchQuery->getId()]);
            }
        }

        return $this->render('search/add.html.twig', [
            'sizes'       => $this->sizeManager->findAllSizes(),
            'searchQuery' => $searchQuery
        ]);
    }

    /**
     * @Route("/bevestigen/{searchQuery}", name="confirm_search_query")
     * @param SearchQuery $searchQuery
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function confirmAction(SearchQuery $searchQuery)
    {
        $this->confirmationMail->sendEmail($searchQuery->getEmail(), $searchQuery->getName(), $searchQuery);
//        $this->findForSearchQueryService->findForSingleSearchQuery($searchQuery);
        return $this->render('search/confirm.html.twig', []);
    }

}
