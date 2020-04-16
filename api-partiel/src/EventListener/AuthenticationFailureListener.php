<?php

namespace App\EventListener;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }


  /**
   * @param AuthenticationFailureListener $event
   */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => '401 Unauthorized',
            'message' => 'Bad credentials, please verify that your username/password are correctly set',
        ];
        $response = new JWTAuthenticationFailureResponse($data);
//je n'ai pas trouvé de moyen de recuperer l'user qui fait l'action, du coup je suis triste mais j'ai essayé =(
        $event->setResponse($response);
    }

}
