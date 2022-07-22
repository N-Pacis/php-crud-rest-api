<?php
namespace Src\Models;

class Product {

    private String $productSKU;
    private String $productName;
    private Float $productPrice;
    private String $ProductType;
    private Float $productHeight;
    private Float $productWidth;
    private Float $productLength;
    private Float $productWeight;
    private Float $productSize;

    public static function initializeValues(String $productSKU, String $productName, Float $productPrice, String $ProductType, Float $productHeight, Float $productWidth, Float $productLength, Float $productWeight, Float $productSize) {
        $instance = new self();

        $instance->productSKU = $productSKU;
        $instance->productName = $productName;
        $instance->productPrice = $productPrice;
        $instance->ProductType = $ProductType;
        $instance->productHeight = $productHeight;
        $instance->productWidth = $productWidth;
        $instance->productLength = $productLength;
        $instance->productWeight = $productWeight;
        $instance->productSize = $productSize;

        return $instance;
    }


    public function getSKU()
    {
        return $this->productSKU;
    }
    public function getName()
    {
        return $this->productName;
    } 
    public function getPrice()
    {
        return $this->productPrice;
    }
    public function getProductType()
    {
        return $this->ProductType;
    }
    public function getHeight()
    {
        return $this->productHeight;
    }
    public function getWidth()
    {
        return $this->productWidth;
    }
    public function getLength()
    {
        return $this->productLength;
    }
    public function getWeight()
    {
        return $this->productWeight;
    }
    public function getSize()
    {
        return $this->productSize;
    }

    public function setSKU(String $SKU)
    {
        $this->productSKU = $SKU;
    }
    public function setName(String $Name)
    {
        $this->productName = $Name;
    }
    public function setPrice(Float $Price)
    {
        $this->productPrice = $Price;
    }
    public function setProductType(String $ProductType)
    {
        $this->ProductType = $ProductType;
    }
    public function setHeight(Float $Height)
    {
        $this->productHeight = $Height;
    }
    public function setWidth(Float $Width)
    {
        $this->productWidth = $Width;
    }
    public function setLength(Float $Length)
    {
        $this->productLength = $Length;
    }
    public function setWeight(Float $Weight)
    {
        $this->productWeight = $Weight;
    }
    public function setSize(Float $Size)
    {
        $this->productSize = $Size;
    }
   
}