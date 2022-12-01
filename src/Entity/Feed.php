<?php

declare(strict_types=1);

namespace App\Entity;

class Feed implements StoreAbleInterface
{
    private string $entityId;

    private string $categoryName;

    private string $sku;

    private string $name;

    private string $description;

    private string $shortDescription;

    private string $price;

    private string $link;

    private string $image;

    private string $brand;

    private string $rating;

    private string $caffeineType;

    private string $count;

    private string $flavored;

    private string $seasonal;

    private string $instock;

    private string $facebook;

    private string $isKCup;

    public function setEntityId(string $entityId): Feed
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function setCategoryName(string $categoryName): Feed
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function setSku(string $sku): Feed
    {
        $this->sku = $sku;

        return $this;
    }

    public function setName(string $name): Feed
    {
        $this->name = $name;

        return $this;
    }

    public function setDescription(string $description): Feed
    {
        $this->description = $description;

        return $this;
    }

    public function setShortDescription(string $shortDescription): Feed
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function setPrice(string $price): Feed
    {
        $this->price = $price;

        return $this;
    }

    public function setLink(string $link): Feed
    {
        $this->link = $link;

        return $this;
    }

    public function setImage(string $image): Feed
    {
        $this->image = $image;

        return $this;
    }

    public function setBrand(string $brand): Feed
    {
        $this->brand = $brand;

        return $this;
    }

    public function setRating(string $rating): Feed
    {
        $this->rating = $rating;

        return $this;
    }

    public function setCaffeineType(string $caffeineType): Feed
    {
        $this->caffeineType = $caffeineType;

        return $this;
    }

    public function setCount(string $count): Feed
    {
        $this->count = $count;

        return $this;
    }

    public function setFlavored(string $flavored): Feed
    {
        $this->flavored = $flavored;

        return $this;
    }

    public function setSeasonal(string $seasonal): Feed
    {
        $this->seasonal = $seasonal;

        return $this;
    }

    public function setInstock(string $instock): Feed
    {
        $this->instock = $instock;

        return $this;
    }

    public function setFacebook(string $facebook): Feed
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function setIsKCup(string $isKCup): Feed
    {
        $this->isKCup = $isKCup;

        return $this;
    }

    public function toArray(): array
    {
        // saved initial XML naming, also didn't set the types of the fields but will need to apply the correct ones if save to mysql for instance
        return [
            'entity_id' => $this->entityId,
            'CategoryName' => $this->categoryName,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'shortdesc' => $this->shortDescription,
            'price' => $this->price,
            'link' => $this->link,
            'image' => $this->image,
            'Brand' => $this->brand,
            'Rating' => $this->rating,
            'CaffeineType' => $this->caffeineType,
            'Count' => $this->count,
            'Flavored' => $this->flavored,
            'Seasonal' => $this->seasonal,
            'Instock' => $this->instock,
            'Facebook' => $this->facebook,
            'IsKCup' => $this->isKCup,
        ];
    }
}
