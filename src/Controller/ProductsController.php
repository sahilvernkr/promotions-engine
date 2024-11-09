<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Cache\PromotionCache;
use App\DTO\LowestPriceEnquiry;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Filter\PromotionsFilterInterface;
use App\Service\Serializer\DTOSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    public function __construct(
        private ProductRepository $repository,
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(
        Request $request,
        int $id,
        DTOSerializer $serializer,
        PromotionsFilterInterface $promotionsFilterApply,
        PromotionCache $promotionCache
    ): Response {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse([
                'error' => 'Promotions Engine failure message'
            ], $request->headers->get('force_fail'));
        }

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

        $product = $this->repository->find($id);
        $lowestPriceEnquiry->setProduct($product);

        $promotions = $promotionCache->findValidProduct($product, $lowestPriceEnquiry->getRequestDate());

        $modifiedEnquiry = $promotionsFilterApply->apply($lowestPriceEnquiry, ...$promotions);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }
}
