<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 */
class Listing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $sellerUuid;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $sellerNickname;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="float")
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $buyerName;

    /**
     * @ORM\Column(type="text")
     */
    private $itemStack;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalData;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $minecraftEnum;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellerUuid(): ?string
    {
        return $this->sellerUuid;
    }

    public function setSellerUuid(string $sellerUuid): self
    {
        $this->sellerUuid = $sellerUuid;

        return $this;
    }

    public function getSellerNickname(): ?string
    {
        return $this->sellerNickname;
    }

    public function setSellerNickname(string $sellerNickname): self
    {
        $this->sellerNickname = $sellerNickname;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBuyerName(): ?string
    {
        return $this->buyerName;
    }

    public function setBuyerName(?string $buyerName): self
    {
        $this->buyerName = $buyerName;

        return $this;
    }

    public function getItemStack(): ?string
    {
        return $this->itemStack;
    }

    public function setItemStack(string $itemStack): self
    {
        $this->itemStack = $itemStack;

        return $this;
    }

    public function getAdditionalData(): ?string
    {
        return $this->additionalData;
    }

    public function setAdditionalData(?string $additionalData): self
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function getMinecraftEnum(): ?string
    {
        return $this->minecraftEnum;
    }

    public function setMinecraftEnum(string $minecraftEnum): self
    {
        $this->minecraftEnum = $minecraftEnum;

        return $this;
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): self
    {
        $this->itemName = $itemName;

        return $this;
    }
}
