<?php
namespace Src\Models;

class Product {

    private $SKU;
    private $Name;
    private $Price;
    private $ProductType;
    private $Height;
    private $Width;
    private $Length;
    private $Weight;
    private $Size;

    public function __construct($SKU, $Name, $Price, $ProductType, $Height, $Width, $Length, $Weight, $Size)
    {
        $this->SKU = $SKU;
        $this->Name = $Name;
        $this->Price = $Price;
        $this->ProductType = $ProductType;
        $this->Height = $Height;
        $this->Width = $Width;
        $this->Length = $Length;
        $this->Weight = $Weight;
        $this->Size = $Size;
    }

    public function getSKU()
    {
        return $this->SKU;
    }
    public function getName()
    {
        return $this->Name;
    } 
    public function getPrice()
    {
        return $this->Price;
    }
    public function getProductType()
    {
        return $this->ProductType;
    }
    public function getHeight()
    {
        return $this->Height;
    }
    public function getWidth()
    {
        return $this->Width;
    }
    public function getLength()
    {
        return $this->Length;
    }
    public function getWeight()
    {
        return $this->Weight;
    }
    public function getSize()
    {
        return $this->Size;
    }

    public function setSKU($SKU)
    {
        $this->SKU = $SKU;
    }
    public function setName($Name)
    {
        $this->Name = $Name;
    }
    public function setPrice($Price)
    {
        $this->Price = $Price;
    }
    public function setProductType($ProductType)
    {
        $this->ProductType = $ProductType;
    }
    public function setHeight($Height)
    {
        $this->Height = $Height;
    }
    public function setWidth($Width)
    {
        $this->Width = $Width;
    }
    public function setLength($Length)
    {
        $this->Length = $Length;
    }
    public function setWeight($Weight)
    {
        $this->Weight = $Weight;
    }
    public function setSize($Size)
    {
        $this->Size = $Size;
    }
   
}