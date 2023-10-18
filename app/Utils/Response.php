<?php

namespace App\Utils;

class Response
{
  public function jsonSuccess(string $message): string
  {
    return json_encode(
      array(
        "type" => "success",
        "message" => $message
      )
    );
  }

  public function jsonError(string $message): string
  {
    return json_encode(
      array(
        "type" => "error",
        "message" => $message
      )
    );
  }
}