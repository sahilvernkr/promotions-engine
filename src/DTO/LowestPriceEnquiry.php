<?php

namespace App\DTO;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Product;
use Symfony\Component\Serializer\Attribute\Ignore;

class LowestPriceEnquiry implements PromotionEnquiryInterface
{   
    #[Ignore]
    private ?Product $product;
    private ?int $quantity;
    private ?string $requestLocation;
    private ?string $voucherCode;
    private ?string $requestDate;
    private ?int $price;
    private ?int $discountedPrice;
    private ?int $promotionId;
    private ?string $promotionName;




    /**
     * Get the value of quantity
     *
     * @return ?int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @param ?int $quantity
     *
     * @return self
     */
    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of requestLocation
     *
     * @return ?string
     */
    public function getRequestLocation(): ?string
    {
        return $this->requestLocation;
    }

    /**
     * Set the value of requestLocation
     *
     * @param ?string $requestLocation
     *
     * @return self
     */
    public function setRequestLocation(?string $requestLocation): self
    {
        $this->requestLocation = $requestLocation;

        return $this;
    }

    /**
     * Get the value of voucherCode
     *
     * @return ?string
     */
    public function getVoucherCode(): ?string
    {
        return $this->voucherCode;
    }

    /**
     * Set the value of voucherCode
     *
     * @param ?string $voucherCode
     *
     * @return self
     */
    public function setVoucherCode(?string $voucherCode): self
    {
        $this->voucherCode = $voucherCode;

        return $this;
    }

    /**
     * Get the value of requestDate
     *
     * @return ?string
     */
    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    /**
     * Set the value of requestDate
     *
     * @param ?string $requestDate
     *
     * @return self
     */
    public function setRequestDate(?string $requestDate): self
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    /**
     * Get the value of price
     *
     * @return ?int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param ?int $price
     *
     * @return self
     */
    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of discountedPrice
     *
     * @return ?int
     */
    public function getDiscountedPrice(): ?int
    {
        return $this->discountedPrice;
    }

    /**
     * Set the value of discountedPrice
     *
     * @param ?int $discountedPrice
     *
     * @return self
     */
    public function setDiscountedPrice(?int $discountedPrice): self
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    /**
     * Get the value of promotionId
     *
     * @return ?int
     */
    public function getPromotionId(): ?int
    {
        return $this->promotionId;
    }

    /**
     * Set the value of promotionId
     *
     * @param ?int $promotionId
     *
     * @return self
     */
    public function setPromotionId(?int $promotionId): self
    {
        $this->promotionId = $promotionId;

        return $this;
    }

    /**
     * Get the value of promotionName
     *
     * @return ?string
     */
    public function getPromotionName(): ?string
    {
        return $this->promotionName;
    }

    /**
     * Set the value of promotionName
     *
     * @param ?string $promotionName
     *
     * @return self
     */
    public function setPromotionName(?string $promotionName): self
    {
        $this->promotionName = $promotionName;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * Get the value of product
     *
     * @return ?Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Set the value of product
     *
     * @param ?Product $product
     *
     * @return self
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
