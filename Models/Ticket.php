<?php

namespace Models;

class Ticket{
    
    private $id;
    private $quantity;
    private $price; //no se si por unidad o el total, pueden ser los dos
    private $user;
    private $function;
    private $status;

    public function __construct(){

    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function getQuantity(){
        return $this->quantity;
    }
    public function setQuantity($quantity){
        $this->quantity=$quantity;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
    }
    public function getUser(){
        return $this->user;
    }
    public function setUser($user){
        $this->user=$user;
    }
    public function getFunction(){
        return $this->function;
    }
    public function setFunction($function){
        $this->function = $function;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status=$status;
    }
}