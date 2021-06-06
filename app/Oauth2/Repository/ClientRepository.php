<?php

namespace App\Oauth2\Repository;

use App\Oauth2\Converters\GrantConverter;
use App\Oauth2\Entity\ClientEntity;
use App\Oauth2\Models\OauthClientModel;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface{
  private $model;
  public function __construct()
  {
    $this->model = new OauthClientModel();
  }

  /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     *
     * @return ClientEntityInterface|null
     */
    public function getClientEntity($clientIdentifier) {
      $data = $this->model->find($clientIdentifier);
      
      if (null === $data) {
        return null;
      }
      $client = new ClientEntity($data);
      return $client;
    }

    /**
     * Validate a client's secret.
     *
     * @param string      $clientIdentifier The client's identifier
     * @param null|string $clientSecret     The client's secret (if sent)
     * @param null|string $grantType        The type of grant the client is using (if sent)
     *
     * @return bool
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType) {
      $client = $this->getClientEntity($clientIdentifier);
      if (!in_array($grantType, $client->getGrants())) {
        return false;
      }
      return hash_equals($client->getSecret(), $clientSecret);
    }

}