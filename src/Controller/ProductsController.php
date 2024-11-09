<?php

namespace App\Controller;

use App\Entity\Promotion;
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
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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
        CacheInterface $cache
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

        $promotions = $cache->get("find-valid-for-product-$id", function (ItemInterface $item)
        use ($product, $lowestPriceEnquiry) {
            return $this->entityManager->getRepository(Promotion::class)->findValidForProduct(
                $product,
                date_create_immutable($lowestPriceEnquiry->getRequestDate())
            );
        });

        $modifiedEnquiry = $promotionsFilterApply->apply($lowestPriceEnquiry, ...$promotions);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }
}
