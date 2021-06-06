<?php

namespace App\Oauth2\Entity;

use App\Oauth2\Converters\ScopeConverter;
use App\Oauth2\Models\OauthClientModel;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class AuthCodeEntity implements AuthCodeEntityInterface {

  private $data;
  private $client;
  private $scopes;
  private $scopeConverter;

  public function __construct($data=NULL)
  {
    $this->data = $data;
    if (null == $data) {
      $this->scopeConverter = new ScopeConverter();
      $this->scopes = [];
      $this->client = null;
    }
    else {
      $clientModel = new OauthClientModel();
      $this->client = $clientModel->find($data['client']);
      $this->scopes = $this->scopeConverter->toLeagueArray($data['scopes']);
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
      return $this->data['identifier'];
    }
  /**
   * Get the token's identifier.
   *
   * @return string
   */
  public function getIdentifier() {
    return $this->data['identifier'];
  }

  /**
   * Set the token's identifier.
   *
   * @param mixed $identifier
   */
  public function setIdentifier($identifier) {
    $this->data['identifier'] = $identifier;
  }

  /**
   * Get the token's expiry date time.
   *
   * @return DateTimeImmutable
   */
  public function getExpiryDateTime() {
    return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->data['expiry']);
  }

  /**
   * Set the date time when the token expires.
   *
   * @param DateTimeImmutable $dateTime
   */
  public function setExpiryDateTime(\DateTimeImmutable $dateTime) {
    $this->data['expiry'] = $dateTime->format('Y-m-d H:i:s');
  }

  /**
   * Set the identifier of the user associated with the token.
   *
   * @param string|int|null $identifier The identifier of the user
   */
  public function setUserIdentifier($identifier) {
    $this->data['user_identifier'] = $identifier;
  }

  /**
   * Get the token user's identifier.
   *
   * @return string|int|null
   */
  public function getUserIdentifier() {
    return $this->data['user_identifier'];
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
    $this->data['client'] = $client->getIdentifier();
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

  /**
   * @return string|null
   */
  public function getRedirectUri() {
    return $this->data['redirect_uri'];
  }

  /**
   * @param string $uri
   */
  public function setRedirectUri($uri) {
    return $this->data['redirect_uri'] = $uri;
  }
}