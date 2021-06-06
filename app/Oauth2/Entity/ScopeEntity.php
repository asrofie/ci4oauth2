<?php

namespace App\Oauth2\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class ScopeEntity implements ScopeEntityInterface {
  private $scope;
  public function __construct($scope)
  {
    $this->scope = $scope;
  }
  /**
   * Get the scope's identifier.
   *
   * @return string
   */
  public function getIdentifier() {
    return $this->scope;
  }

  public function jsonSerialize() {
    return json_encode($this->scope);
  }
}