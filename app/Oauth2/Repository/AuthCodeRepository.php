<?php

namespace App\Oauth2\Repository;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface {

  private $model;
  public function __construct()
  {
    $this->model = new 
  }
  /**
   * Creates a new AuthCode
   *
   * @return AuthCodeEntityInterface
   */
  public function getNewAuthCode() {

  }

  /**
   * Persists a new auth code to permanent storage.
   *
   * @param AuthCodeEntityInterface $authCodeEntity
   *
   * @throws UniqueTokenIdentifierConstraintViolationException
   */
  public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity) {

  }

  /**
   * Revoke an auth code.
   *
   * @param string $codeId
   */
  public function revokeAuthCode($codeId) {

  }

  /**
   * Check if the auth code has been revoked.
   *
   * @param string $codeId
   *
   * @return bool Return true if this code has been revoked
   */
  public function isAuthCodeRevoked($codeId){

  }
}

