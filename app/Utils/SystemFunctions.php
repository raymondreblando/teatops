<?php

namespace App\Utils;

class SystemFunctions 
{
    public function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function randomString($length){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = '';
            for ($i = 0; $i < $length; $i++) {
                $string .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $string;
    }
    public function generatePin() {
        $pin = rand(1000, 9999);

        $pin = str_pad($pin, 4, '0', STR_PAD_LEFT);
    
        return $pin;
    }      
    public function formatDateTime($date, $format){ 
        $formattedDate = date($format, strtotime($date));
        return $formattedDate;
    }
    public function toast_message($message, $type, $reload, $others){
        $data = array(
            'identifier' => 'toast',
            'message' => $message,
            'type' => $type,
            'reload' => $reload,
            'others' => $others
        );
        header('Content-Type: application/json');
        $json = json_encode($data);
        echo $json;
    }
    public function html_fetch($value){
        $data = array(
            'identifier' => 'html',
            'value' => $value
        );
        header('Content-Type: application/json');
        $json = json_encode($data);
        echo $json;
    }
    public function timeAgo($timestamp) {
        $timeAgo = time() - strtotime($timestamp);
    
        if ($timeAgo < 60) {
            return $timeAgo . " seconds ago";
        } elseif ($timeAgo < 3600) {
            $minutes = floor($timeAgo / 60);
            return $minutes . " minutes ago";
        } elseif ($timeAgo < 86400) {
            $hours = floor($timeAgo / 3600);
            return $hours . " hours ago";
        } elseif ($timeAgo < 2592000) {
            $days = floor($timeAgo / 86400);
            return $days . " days ago";
        } elseif ($timeAgo < 31536000) {
            $months = floor($timeAgo / 2592000);
            return $months . " months ago";
        } else {
            $years = floor($timeAgo / 31536000);
            return $years . " years ago";
        }
    }    
} 