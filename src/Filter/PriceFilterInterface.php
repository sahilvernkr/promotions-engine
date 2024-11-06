<?php

namespace App\Filter;

use App\Entity\Promotion;
use App\DTO\PriceEnquiryInterface;
use App\Filter\PromotionsFilterInterface;

interface PriceFilterInterface extends PromotionsFilterInterface
{
    public function apply(PriceEnquiryInterface $enquiry, Promotion ...$promotion): PriceEnquiryInterface;
}
