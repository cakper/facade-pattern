<?php

interface TemplatedMailer
{
    public function send($email, $title, $templateName);
}