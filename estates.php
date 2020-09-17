<?php

class RealEstateData {
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
    public $Contact;
    public $Comments;
}

class Comment {
    public $RealEstateId;
    public $Content;
    public $Username;
    public $CreatedOn;

    public function __construct($id, $content, $username, $createdOn)
    {
        $this->RealEstateId = $id;
        $this->Content = $content;
        $this->Username = $username;
        $this->CreatedOn = $createdOn;
    }
}

class RealEstate {
    public $estates;
    public $IsAuthorized;

    public function __construct($auth)
    {
        $this->IsAuthorized = $auth;

        $obj1 = new RealEstateData;
        $obj1->Id = 1;
        $obj1->Title = "Big House";
        $obj1->SellingPrice = 1100400;
        $obj1->RentingPrice = 0;
        $obj1->CanBeSold = true;
        $obj1->CanBeRented = false;
        $obj1->CreatedOn = "2020-08-22T16:12:24.98";
        $obj1->ConstructionYear = 2003;
        $obj1->Address = "Konkelvägen 34";
        $obj1->RealEstateType = "House";
        $obj1->Description = "Very nice and luxury big house.";
        if($this->IsAuthorized){
            $obj1->Contact = "1234 56 78 90";
            $obj1->Comments = array(
                new Comment(1, "Nice house!", "Linken", "2020-12-01"),
                new Comment(1, "Can I fit my wiener in it?", "Ricardo", "2019-10-29"),
                new Comment(1, "Very big", "Danielo", "2020-09-15")
            );
        }
        else {
            unset($obj1->Contact);
            unset($obj1->Comments);
        }
    
        $obj2 = new RealEstateData;
        $obj2->Id = 2;
        $obj2->Title = "Small House";
        $obj2->SellingPrice = 765000;
        $obj2->RentingPrice = 4690;
        $obj2->CanBeSold = true;
        $obj2->CanBeRented = true;
        $obj2->CreatedOn = "2020-05-12T12:19:34.31";
        $obj2->ConstructionYear = 2009;
        $obj2->Address = "Pelikanvägen 11";
        $obj2->RealEstateType = "House";
        $obj2->Description = "Nice small house outside town.";
        if($this->IsAuthorized){
            $obj2->Contact = "1234 56 78 90";
            $obj2->Comments = array(
                new Comment(2, "Nice house!", "Linken", "2020-12-01"),
                new Comment(2, "Can I fit my wiener in it?", "Ricardo", "2019-10-29"),
                new Comment(2, "Very big", "Danielo", "2020-09-15")
            );
        }
        else {
            unset($obj2->Contact);
            unset($obj2->Comments);
        }
    
        $obj3 = new RealEstateData;
        $obj3->Id = 3;
        $obj3->Title = "Medium Apartment";
        $obj3->SellingPrice = 0;
        $obj3->RentingPrice = 13500;
        $obj3->CanBeSold = false;
        $obj3->CanBeRented = true;
        $obj3->CreatedOn = "2020-05-12T12:19:34.31";
        $obj3->ConstructionYear = 2016;
        $obj3->Address = "Apelvägen 101";
        $obj3->RealEstateType = "Apartment";
        $obj3->Description = "Cool apartment.";
        if($this->IsAuthorized){
            $obj3->Contact = "1234 56 78 90";
            $obj3->Comments = array(
                new Comment(3, "Nice house!", "Linken", "2020-12-01"),
                new Comment(3, "Can I fit my wiener in it?", "Ricardo", "2019-10-29"),
                new Comment(3, "Very big", "Danielo", "2020-09-15")
            );
        }
        else {
            unset($obj3->Contact);
            unset($obj3->Comments);
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