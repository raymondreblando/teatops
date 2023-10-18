<?php

namespace App\Utils;

use DateTime;

class Utilities
{
  public static function sanitize(string $data): string
  {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
  }

  public static function hashPassword(string $password): string
  {
    return password_hash($password, PASSWORD_BCRYPT, [10]);
  }

  public static function formatDate(string $date, string $format): string
  {
    return date($format, strtotime($date));
  }

  public static function getPercentage(int $total, int $count): int
  {
    return ($count / $total) * 100;
  }

  public static function generateOrderNo(): int
  {
    return rand(time(), 999999);
  }

  public function getDatesBetween(string $startDate, string $endDate): array
  {
    $dates = array();
    $currentDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    while ($currentDate <= $endDate) {
        $dates[] = $currentDate->format('Y-m-d');
        $currentDate->modify('+1 day');
    }

    return $dates;
}

  public static function isCustomer(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == "8a98acb4-2e77-11ee-9e02-088fc30176f9" ? true : false;
  }

  public static function isAdmin(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == "79205bd2-2e77-11ee-9e02-088fc30176f9" ? true : false;
  }

  public static function isEmployee(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == "84c7e7de-2e77-11ee-9e02-088fc30176f9" ? true : false;
  }

  public static function redirectUnauthorize(): void
  {
    if(!isset($_SESSION['uid']) AND !isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.'');
      exit();
    }
  }

  public static function redirectAuthorize(string $route): void
  {
    if(isset($_SESSION['uid']) AND isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.''.$route.'');
      exit();
    }
  }
}