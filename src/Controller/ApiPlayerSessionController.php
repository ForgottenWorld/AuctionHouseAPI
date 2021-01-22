<?php

namespace App\Controller;

use App\Repository\PlayerSessionRepository;
use App\Entity\PlayerSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* Class ApiPlayerSessionController
* @package App\Controller
* @Route("/api/session", name="session_api")
*/
class ApiPlayerSessionController extends BaseApiController
{
	/**
	* @param Request $request
	* @param PlayerSessionRepository $playerSessionRepository
	* @return JsonResponse
	* @throws \Exception
	* @Route("/updateToken/{username}/{token}", name="session_api_update_token", methods={"GET"})
	*/
    public function updateToken(Request $request, $username, $token, PlayerSessionRepository $playerSessionRepository)
    {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		$entityManager = $this -> getDoctrine() -> getManager();
		
		$playerSession = $playerSessionRepository->findOneBy(array('username' => $username));
		if(empty($playerSession)) {			
			$playerSession = new PlayerSession();			
		}
		
		$playerSession -> setUsername($username);
		$playerSession -> setToken($token);
		$playerSession -> setIsValidated(false);
		
		$now = new \DateTime('now');
		$expirationDate = $now -> modify('+1 month');
		$playerSession -> setExpiration($expirationDate);
		
		$entityManager -> persist($playerSession);
		$entityManager -> flush();
		
		return $this->json($playerSession);
    }
	
	/**
	* @param Request $request
	* @param PlayerSessionRepository $playerSessionRepository
	* @return JsonResponse
	* @throws \Exception
	* @Route("/check/{token}", name="session_api_check_token", methods={"GET"})
	*/
    public function checkToken(Request $request, $token, PlayerSessionRepository $playerSessionRepository)
    {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		return $this -> json($this -> validateUserToken($token));
    }
}