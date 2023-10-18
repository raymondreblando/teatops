<?php

namespace App\Utils;

class RedirectPage 
{
    // Method to redirect to other page
    public function redirect($url) {
        header("Location: $url");
        exit;
    } 
    // Method to verify if user is not logged in then redirect to specific page
    public function checkLoggedIn($location){
        if(!isset($_SESSION["loggedin"])){
            header("Location: $location");
            exit;
        }
    }
    // Method to redirect the user to specific page if not admin
    public function redirectNotAdmin($location){
        if($_SESSION["role"] !== "968375857"){
            header("Location: $location");
            exit;
        }
    }
     // Method to redirect the user to specific page if not customer
     public function redirectNotCustomer($location){
        if($_SESSION["role"] !== "564570857"){
            header("Location: $location");
            exit;
        }
    }
    // Method to logout the user
    public function logout(){
        $_SESSION = array();
        session_unset();
        session_destroy();
        header('Location: '. SYSTEM_URL .'');
        exit;
    }
}