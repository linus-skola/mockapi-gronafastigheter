<?php

class RealEstateData {
    public $Id;
    public $Title;
    public $SellingPrice;
    public $RentingPrice;
    public $CanBeSold;
    public $CanBeRented;
}

class RealEstate {
    public $estates;

    public function __construct()
    {
        $obj1 = new RealEstateData;
        $obj1->Id = 1;
        $obj1->Title = "Big House";
        $obj1->SellingPrice = 1100400;
        $obj1->RentingPrice = null;
        $obj1->CanBeSold = true;
        $obj1->CanBeRented = false;
    
        $obj2 = new RealEstateData;
        $obj2->Id = 2;
        $obj2->Title = "Small House";
        $obj2->SellingPrice = 765000;
        $obj2->RentingPrice = 4690;
        $obj2->CanBeSold = true;
        $obj2->CanBeRented = true;
    
        $obj3 = new RealEstateData;
        $obj3->Id = 3;
        $obj3->Title = "Medium Apartment";
        $obj3->SellingPrice = null;
        $obj3->RentingPrice = 13500;
        $obj3->CanBeSold = false;
        $obj3->CanBeRented = true;
    
        $this->estates = array(
            $obj1,
            $obj2,
            $obj3
        );
    }

    function get(){
        return $this->estates;
    }

    function getById($id){
        foreach($this->estates as $estate){
            if($estate->Id == $id){
                return $estate;
            }
        }
        return null;
    }
}