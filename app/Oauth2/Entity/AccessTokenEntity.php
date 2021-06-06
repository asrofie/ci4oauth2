<?php

namespace App\Oauth2\Entity;

use App\Oauth2\Converters\ScopeConverter;
use App\Oauth2\Models\OauthClientModel;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class AccessTokenEntity implements AccessTokenEntityInterface {

  private $accessToken;
  private $client;
  private $scopes;
  private $scopeConverter;

  public function __construct($accessToken=NULL)
  {
    $this->accessToken = $accessToken;
    if (null == $accessToken) {
      $this->scopeConverter = new ScopeConverter();
      $this->scopes = [];
      $this->client = null;
    }
    else {
      $clientModel = new OauthClientModel();
      $this->client = $clientModel->find($accessToken['client']);
      $this->scopes = $this->scopeConverter->toLeagueArray($accessToken['scopes']);
    }
  }
  /**
   * Set a private key used to encrypt the access token.
   */
  public function setPrivateKey(CryptKey $privateKey) {

  }

  /**
     * Generate a string representation of the access token.
     */
    public function __toString() {
      return $this->accessToken['identifier'];
    }
  /**
   * Get the token's identifier.
   *
   * @return string
   */
  public function getIdentifier() {
    return $this->accessToken['identifier'];
  }

  /**
   * Set the token's identifier.
   *
   * @param mixed $identifier
   */
  public function setIdentifier($identifier) {
    $this->accessToken['identifier'] = $identifier;
  }

  /**
   * Get the token's expiry date time.
   *
   * @return DateTimeImmutable
   */
  public function getExpiryDateTime() {
    return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->accessToken['expiry']);
  }

  /**
   * Set the date time when the token expires.
   *
   * @param DateTimeImmutable $dateTime
   */
  public function setExpiryDateTime(\DateTimeImmutable $dateTime) {
    $this->accessToken['expiry'] = $dateTime->format('Y-m-d H:i:s');
  }

  /**
   * Set the identifier of the user associated with the token.
   *
   * @param string|int|null $identifier The identifier of the user
   */
  public function setUserIdentifier($identifier) {
    $this->accessToken['user_identifier'] = $identifier;
  }

  /**
   * Get the token user's identifier.
   *
   * @return string|int|null
   */
  public function getUserIdentifier() {
    return $this->accessToken['user_identifier'];
  }

  /**
   * Get the client that the token was issued to.
   *
   * @return ClientEntityInterface
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * Set the client that the token was issued to.
   *
   * @param ClientEntityInterface $client
   */
  public function setClient(ClientEntityInterface $client) {
    $this->client = $client;
    $this->accessToken['client'] = $client->getIdentifier();
  }

  /**
   * Associate a scope with the token.
   *
   * @param ScopeEntityInterface $scope
   */
  public function addScope(ScopeEntityInterface $scope) {
    $this->scopes[] = $scope;  
  }

  /**
   * Return an array of scopes associated with the token.
   *
   * @return ScopeEntityInterface[]
   */
  public function getScopes() {
    return $this->scopes;   
  }
}