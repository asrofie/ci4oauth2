<?php

namespace App\Oauth2\Repository;

use App\Oauth2\Converters\ScopeConverter;
use App\Oauth2\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface{

  private $model;
  private $scopeConverter;
  public function __construct()
  {
    $this->model= model('OauthAccessToken');
    $this->scopeConverter = new ScopeConverter();
  }
  /**
     * Create a new access token
     *
     * @param ClientEntityInterface  $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed                  $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessTokenEntityInterface {
      $accessToken = new AccessTokenEntity();
      $accessToken->setClient($clientEntity);
      $accessToken->setUserIdentifier($userIdentifier);
      foreach($scopes as $scope) {
        $accessToken->addScope($scope);
      }
      return $accessToken;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity) {
      $accessToken = $this->model->find($accessTokenEntity->getIdentifier());
      if (null != $accessToken) {
        throw UniqueTokenIdentifierConstraintViolationException::create();
      }
      $data = [
        'identifier' => $accessTokenEntity->getIdentifier(),
        'expiry' => $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s'),
        'client' => $accessTokenEntity->getClient()->getIdentifier(),
        'user_identifier' => $accessTokenEntity->getUserIdentifier(),
        'scopes' => $this->scopeConverter->toDomainArray($accessTokenEntity->getScopes())
      ];
      $this->model->insert($data);
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId) {
      $accessToken = $this->model->find($tokenId);

      if (null == $accessToken) {
        return;
      }

      $accessToken['revoked'] = 1;
      $this->model->update($accessToken['identifier'], $accessToken);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId) {
      $accessToken = $this->model->find($tokenId);

      if (null === $accessToken) {
        return true;
      }

      return $accessToken['revoked'];
    }
}