<?php

namespace App\Oauth2\Converters;

class GrantConverter {
  public function toDomainArray($grants) {
    return implode(",",$grants);
  }
  public function toLeagueArray($grants) {
    return explode(",",$grants);
  }
}