<?php

namespace spec;

use Swift_Mailer;
use Swift_Mime_Message;
use TemplatedMailer;
use TemplatedSwiftMailer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Twig_Environment;

/**
 * @mixin TemplatedSwiftMailer
 */
class TemplatedSwiftMailerSpec extends ObjectBehavior
{
    function let(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->beConstructedWith($mailer, $twig);
    }

    function it_is_a_templated_mailer()
    {
        $this->shouldBeAnInstanceOf(TemplatedMailer::class);
    }

    function it_sends_a_swift_message_using_swift_mailer(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $email = 'cakper@gmail.com';
        $title = 'Test title';
        $templateName = 'template-name.html.twig';
        $renderedTemplate = 'rendered-template';

        $twig->render($templateName)->willReturn($renderedTemplate);
        $mailer->send(Argument::that(function(Swift_Mime_Message $message) use ($email, $renderedTemplate) {
            return $message->getBody() === $renderedTemplate &&
                   $message->getTo() === [$email => null];
        }))->shouldBeCalled();

        $this->send($email, $title, $templateName);
    }
}
