<?php

namespace App\Tests\Unit;

use App\Entity\Promotion;
use App\Tests\ServiceTestCase;
use App\DTO\LowestPriceEnquiry;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\EvenItemsMultiplier;

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

    /** @test */
    public function FixedPriceVoucher_returns_a_correctly_modified_price(): void
    {
        //Given
        $fixedPriceVoucher = new FixedPriceVoucher();

        $promotion = new Promotion();
        $promotion->setName('Voucher OU812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria(["code" => "OU812"]);
        $promotion->setType('fixed_price_voucher');

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode('OU812');

        //When
        $modifiedPrice = $fixedPriceVoucher->modify(100, 5, $promotion, $enquiry);

        //Then
        $this->assertEquals(500, $modifiedPrice);
    }

    /** @test */
    public function EvenItemsMultiplier_returns_a_correctly_modified_price(): void
    {
        //Given
        $evenItemsMultiplier = new EvenItemsMultiplier();

        $promotion = new Promotion();
        $promotion->setName('Buy one get one free');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["minimum_quantity" => 2]);
        $promotion->setType('even_items_multiplier');

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);

        //When
        $modifiedPrice = $evenItemsMultiplier->modify(100, 5, $promotion, $enquiry);

        //Then
        $this->assertEquals(300, $modifiedPrice);
    }
}
