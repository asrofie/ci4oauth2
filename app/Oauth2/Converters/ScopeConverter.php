<?php

namespace App\Oauth2\Converters;

use App\Oauth2\Entity\ScopeEntity;

class ScopeConverter {
  public function toDomainArray($scopes) {
    $result = [];
    foreach($scopes as $scope) {
      $result[] = $scope->getIdentifier();
    }
    return implode(",", $result);
  }
  public function toLeagueArray($scopes) {
    $array = explode(",",$scopes);
    $result = [];
    foreach($array as $el) {
      $scope = new ScopeEntity($el);
      $result[] = $scope;
    }
    return $result;
  }
}