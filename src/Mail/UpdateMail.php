<?php


namespace App\Mail;

use Psr\Log\LoggerInterface;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UpdateMail
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twig,
        LoggerInterface $logger
    ) {

        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->logger = $logger;
    }

    /**
     * @param string $emailAddress
     * @param string $name
     * @param string $matrass
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail(string $emailAddress, string $name, string $matrass): int
    {
        $this->logger->debug('Sending mail to ', ['email' => $emailAddress]);
        $message = (new \Swift_Message('Matras gevonden'))
            ->setFrom('rhf@ziggo.nl')
            ->setTo($emailAddress)
            ->setBody(
                $this->twig->render(
                // templates/emails/registration.html.twig
                    'mail/update.html.twig',
                    [
                        'name'    => $name,
                        'matrass' => $matrass
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);

    }

}
