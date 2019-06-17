<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Doctrine\ORM\EntityManager;
use App\Entity\User;

class ActivityListener
{
    protected $tokenContext;
    protected $doctrine;

    public function __construct(TokenStorage $tokenContext, $doctrine)
    {
        $this->tokenContext = $tokenContext;
        $this->doctrine = $doctrine;
    }

    public function onCoreController(FilterControllerEvent $event)
    {
// Check that the current request is a "MASTER_REQUEST"
// Ignore any sub-request
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
// Check token authentication availability
        if ($this->tokenContext->getToken()) {
            $user = $this->tokenContext->getToken()->getUser();
            if (($user instanceof User) && ($user->isCredentialsNonExpired())) {
                $user->setLastActivityAt(new \DateTime());
                $this->doctrine->getManager()->flush($user);
            }
        }
    }
}