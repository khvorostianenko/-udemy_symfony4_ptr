<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    /**
     * Уникальное имя для события
     */
    const NAME = 'user.register';
    
    /**
     * @var User
     */
    private $registeredUser;
    
    public function __construct(User $registeredUser)
    {
        $this->registeredUser = $registeredUser;
    }
    
    /**
     * @return User
     */
    public function getRegisteredUser(): User
    {
        return $this->registeredUser;
    }
}
