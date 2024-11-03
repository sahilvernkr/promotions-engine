<?php

namespace App\Tests\Unit;

use App\Entity\Promotion;
use App\Tests\ServiceTestCase;
use App\DTO\LowestPriceEnquiry;
use App\Filter\Modifier\DateRangeMultiplier;

class PriceModifiersTest extends ServiceTestCase
{
    /** @test */
    public function DateRangeMultiplier_returns_a_correctly_modified_price(): void
    {
        //Given

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setRequestDate('2022-11-27');

        $promotion = new Promotion();
        $promotion->setName('Black Friday half price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotion->setType('date_range_multiplier');

        $dateRangeModifier = new DateRangeMultiplier();

        //When
        $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);

        //Then
        $this->assertEquals(250, $modifiedPrice);
    }

    //  /** @test */
    //  public function FixedPriceVoucher_returns_a_correctly_modified_price(): void
    //  {
    //      //Given
 
    //      $enquiry = new LowestPriceEnquiry();
    //      $enquiry->setQuantity(5);
    //      $enquiry->setRequestDate('2022-11-27');
 
    //      $promotion = new Promotion();
    //      $promotion->setName('Black Friday half price sale');
    //      $promotion->setAdjustment(0.5);
    //      $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
    //      $promotion->setType('date_range_multiplier');
 
    //      $dateRangeModifier = new DateRangeMultiplier();
 
    //      //When
    //      $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);
 
    //      //Then
    //      $this->assertEquals(250, $modifiedPrice);
    //  }


}
