<?php

class TemplatedSwiftMailer implements TemplatedMailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send($email, $title, $templateName)
    {
        $message = new Swift_Message($title, $this->twig->render($templateName));
        $message->setTo($email);

        $this->mailer->send($message);
    }
}
