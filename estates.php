<?php

class RealEstateData {
    public $Authorized;
    public $Id;
    public $Title;
    public $SellingPrice;
    public $RentingPrice;
    public $CanBeSold;
    public $CanBeRented;
    public $CreatedOn;
    public $ConstructionYear;
    public $Address;
    public $RealEstateType;
    public $Description;
    //public $Contact;
    //public $Comments;
}

class Comment {
    public $RealEstateId;
    public $Content;
    public $Username;
    public $CreatedOn;
}

class RealEstate {
    public $estates;
    public $IsAuthorized;

    public function __construct()
    {
        $obj1 = new RealEstateData;
        $obj1->Id = 1;
        $obj1->Title = "Big House";
        $obj1->SellingPrice = 1100400;
        $obj1->RentingPrice = 0;
        $obj1->CanBeSold = true;
        $obj1->CanBeRented = false;
        $obj1->CreatedOn = "2020-11-22T16:12:24.98";
        $obj1->ConstructionYear = 2003;
        $obj1->Address = "Konkelvägen 34";
        $obj1->RealEstateType = "House";
        $obj1->Description = "Very nice and luxury big house.";
        if($this->IsAuthorized){
            $obj1->Contact = "1234 56 78 90";
            $obj1->Comments = array(
                new Comment(1, "Helo", "Linus", "2020-01-01"),
                new Comment(1, "Helo", "Linus", "2020-01-01"),
                new Comment(1, "Helo", "Linus", "2020-01-01")
            );
        }
    
        $obj2 = new RealEstateData;
        $obj2->Id = 2;
        $obj2->Title = "Small House";
        $obj2->SellingPrice = 765000;
        $obj2->RentingPrice = 4690;
        $obj2->CanBeSold = true;
        $obj2->CanBeRented = true;
        if($this->IsAuthorized){
            
        }
    
        $obj3 = new RealEstateData;
        $obj3->Id = 3;
        $obj3->Title = "Medium Apartment";
        $obj3->SellingPrice = 0;
        $obj3->RentingPrice = 13500;
        $obj3->CanBeSold = false;
        $obj3->CanBeRented = true;
        if($this->IsAuthorized){
            
        }
    
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
        http_response_code(404);
        throw new Exception("Not Found.");
    }
}