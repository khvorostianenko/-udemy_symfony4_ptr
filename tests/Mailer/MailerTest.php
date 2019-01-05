<?php

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testSendConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john@some.em');
        
        $swiftMock = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
    
        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
            
        $mailer = new Mailer($swiftMock, $twigMock, 'me@domain.com');
        $mailer->sendConfirmationEmail($user);
    }
}