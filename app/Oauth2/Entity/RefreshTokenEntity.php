<?php

namespace App\Oauth2\Entity;

use App\Oauth2\Models\OauthAccessTokenModel;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshTokenEntity implements RefreshTokenEntityInterface {

  private $data;
  private $accessToken;

  public function __construct($data=NULL)
  {
    $this->data = $data;
    if ($data) {
      $accessTokenModel = new OauthAccessTokenModel();
      $this->accessToken = $accessTokenModel->find($data['access_token']);
    }

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
     * Set the access token that the refresh token was associated with.
     *
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken) {
      $this->accessToken = $accessToken;
      $this->data['access_token'] = $accessToken->getIdentifier();
    }

    /**
     * Get the access token that the refresh token was originally associated with.
     *
     * @return AccessTokenEntityInterface
     */
    public function getAccessToken() {
      return $this->accessToken;
    }
}