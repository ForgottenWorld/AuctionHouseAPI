<?php

namespace App\Controller;

use App\Entity\PlayerSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseApiController extends AbstractController
{
    protected function validateUserToken($token) {
		$entityManager = $this -> getDoctrine() -> getManager();
		
		$response = new \stdClass;
		$response -> status = 1;
		
		$playerSession = $entityManager
            ->getRepository(PlayerSession::class)
            ->findOneBy(array('token' => $token));
			
		if(empty($playerSession)) {
			$response -> status = -1;
			$response -> error = 'No user found for the given token';
			return $response;
		}
		
		if(!empty($playerSession) && empty($playerSession -> getIsValidated())) {
			$response -> status = -2;
			$response -> error = 'The token for the user '.$playerSession -> getUsername().' must be validated before proceeding';
			return $response;
		}
		
		$now = new \DateTime("now");
		if(!empty($playerSession) && $playerSession -> getExpiration() < $now) {
			$response -> status = -3;
			$response -> error = 'The token for the user '.$playerSession -> getUsername().' expired';
			return $response;
		}
		
		
		$response -> error = 'The token is valid for the user ' . $playerSession -> getUsername();
		return $response;
	}
}