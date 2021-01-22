<?php

namespace App\Controller;

use App\Repository\ListingRepository;
use App\Repository\PlayerSessionRepository;
use App\Entity\PlayerSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* Class ApiListingController
* @package App\Controller
* @Route("/api/listing", name="listing_api")
*/
class ApiListingController extends BaseApiController
{
	/**
	* @param Request $request
	* @param EntityManagerInterface $entityManager
	* @param ListingRepository $listingRepository
	* @return JsonResponse
	* @throws \Exception
	* @Route("/list", name="listing_api_list", methods={"GET"})
	*/
    public function getListings(Request $request, ListingRepository $listingRepository)
    {		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		$isValid = $this -> validateUserToken($request -> get('token'));
		if($isValid -> status != 1) {
			return $this->json($isValid);
		}
		
		$data = $listingRepository->findAll();
		
		$connection = $this -> getDoctrine() -> getManager() -> getConnection();
		$sql = "SELECT 
					minecraft_enum as minecraftEnum,
					min(unit_price) as minUnitPrice,
					count(1) as totalCount
				FROM listing
				WHERE minecraft_enum IS NOT NULL
				AND minecraft_enum <> ''
				GROUP BY minecraft_enum";
		$statement = $connection -> prepare($sql);
		$statement -> execute();
		$data = $statement -> fetchAll();
		
		return $this->json($data);
    }
	
	/**
	* @param Request $request
	* @param EntityManagerInterface $entityManager
	* @param ListingRepository $listingRepository
	* @return JsonResponse
	* @throws \Exception
	* @Route("/listByEnum/{minecraftEnum}", name="listing_api_list_by_enum", methods={"GET"})
	*/
    public function getListingsByEnum(Request $request, ListingRepository $listingRepository, $minecraftEnum)
    {		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		$isValid = $this -> validateUserToken($request -> get('token'));
		if($isValid -> status != 1) {
			return $this->json($isValid);
		}
		
		$data = $listingRepository->findBy(array('minecraftEnum' => $minecraftEnum));
		return $this->json($data);
    }
	
	/**
	* @param Request $request
	* @param EntityManagerInterface $entityManager
	* @param ListingRepository $listingRepository
	* @param $id
	* @return JsonResponse
	* @throws \Exception
	* @Route("/get/{id}", name="listing_api_get", methods={"GET"})
	*/
    public function getListingById(Request $request, ListingRepository $listingRepository, $id)
    {		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		$isValid = $this -> validateUserToken($request -> get('token'));
		if($isValid -> status != 1) {
			return $this->json($isValid);
		}
		
		$data = $listingRepository->find($id) ?: array();
		
		$fgHideItemStack = !empty($request -> get('hide_itemstack'));
		if($fgHideItemStack) {
			$data -> setItemStack("");
		}
		
		return $this->json($data);
    }
	
	/**
	* @param Request $request
	* @param EntityManagerInterface $entityManager
	* @param ListingRepository $listingRepository
	* @param $id
	* @return JsonResponse
	* @throws \Exception
	* @Route("/placeOrder/{orderId}/{token}", name="listing_api_place_order", methods={"GET"})
	*/
    public function placeOrder(Request $request, ListingRepository $listingRepository, PlayerSessionRepository $playerSessionRepository, $orderId, $token)
    {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		$isValid = $this -> validateUserToken($request -> get('token'));
		if($isValid -> status != 1) {
			return $this->json($isValid);
		}
		
		$entityManager = $this -> getDoctrine() -> getManager();
		$playerSession = $entityManager
            ->getRepository(PlayerSession::class)
            ->findOneBy(array('token' => $token));
		
		$listing = $listingRepository->find($orderId);
		
		$response = new \stdClass;
		
		if(empty($listing)) {
			$response -> status = -4;
			$response -> error = "Order for ID $orderId not found.";
			return $this -> json($response);
		}
		
		$ORDER_PLACED = 2;
		
		if($listing -> getStatus() == $ORDER_PLACED) {
			$response -> status = -5;
			$response -> error = "Order for ID $orderId already placed.";
			return $this -> json($response);
		}
		
		$listing -> setBuyerName($playerSession -> getUsername());
		$listing -> setStatus($ORDER_PLACED);
		
		$entityManager -> persist($listing);
		$entityManager -> flush();
	
		$response -> status = 1;
		return $this->json($response);
    }
}