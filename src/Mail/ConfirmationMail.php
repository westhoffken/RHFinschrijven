<?php


namespace App\Mail;

use App\Entity\SearchQuery;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConfirmationMail
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $emailAddress
     * @param string $name
     * @param SearchQuery $searchQuery
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail(string $emailAddress, string $name, SearchQuery $searchQuery): int
    {
        $message = (new \Swift_Message('Bevestiging inschrijving koopjeshoek Royal Healthfoam'))
            ->setFrom('rhf@ziggo.nl')
            ->setTo($emailAddress)
            ->setBody(
                $this->twig->render(
                // templates/emails/registration.html.twig
                    'mail/confirmation.html.twig',
                    [
                        'name' => $name,
                        'product' => $this->makeMatrassText($searchQuery)
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);

    }

    /**
     * @param SearchQuery $searchQuery
     * @return string
     */
    private function makeMatrassText(SearchQuery $searchQuery): string
    {
        return
            $searchQuery->getSize()->getSizeText()
            . ' - ' .
            SearchQuery::MATRASS_FIRMNESS[$searchQuery->getFirmness()]
            . ' - ' .
            SearchQuery::MATRASS_CLASSIFICATION[$searchQuery->getClassification()]
            . ' - ' .
            SearchQuery::MATRASS_TYPE[$searchQuery->getType()] . ' matras'
            ;
    }

}
