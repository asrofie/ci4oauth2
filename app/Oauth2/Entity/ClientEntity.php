<?php

namespace App\Oauth2\Entity;

use App\Oauth2\Converters\GrantConverter;

class ClientEntity implements \League\OAuth2\Server\Entities\ClientEntityInterface {

  private $client;
  private $grants;

  public function __construct($client=NULL)
  {
    $this->client = $client;
    $converter = new GrantConverter();
    if ($client) {
      $this->grants = $converter->toLeagueArray($client['grants']);
    }
  }

   /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()  {
      return $this->client['identifier'];
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName() {
      return $this->client['name'];
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri() {
      return $this->client['redirect_uris'];
    }

    /**
     * Returns true if the client is confidential.
     *
     * @return bool
     */
    public function isConfidential() {
      return true;
    }

    public function getGrants() {
      return $this->grants;
    }

    public function getSecret() {
      return $this->client['secret'];
    }
}