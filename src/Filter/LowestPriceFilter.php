<?php

namespace App\Filter;

use App\Entity\Promotion;
use App\DTO\PriceEnquiryInterface;
use App\Filter\Modifier\Factory\PriceModifierFactoryInterface;

class LowestPriceFilter implements PriceFilterInterface
{
  public function __construct(private PriceModifierFactoryInterface  $priceModifierFactory) {}

  /**
   * @param LowestPriceEnquiry $enquiry
   */
  public function apply(PriceEnquiryInterface $enquiry, Promotion ...$promotions): PriceEnquiryInterface
  {
    $price = $enquiry->getProduct()->getPrice();
    $quantity = $enquiry->getQuantity();
    $lowestPrice = $quantity * $price;
    $enquiry->setPrice($price);

    foreach ($promotions as $promotion) {
      $priceModifier = $this->priceModifierFactory->create($promotion->getType());

      $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $enquiry);

      if ($modifiedPrice < $lowestPrice) {

        $enquiry->setDiscountedPrice($modifiedPrice);
        $enquiry->setPromotionId($promotion->getId());
        $enquiry->setPromotionName($promotion->getName());

        $lowestPrice = $modifiedPrice;
      }
    }
    return $enquiry;
  }
}
