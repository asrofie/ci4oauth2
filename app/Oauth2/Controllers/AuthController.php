<?php

namespace App\Oauth2\Controllers;

use App\Oauth2\Repository\ClientRepository;
use CodeIgniter\RESTful\ResourceController;
use \Defuse\Crypto\Key;
use League\OAuth2\Server\AuthorizationServer;

class AuthController extends ResourceController {
  public function tokenAction() {
  $clientRepository = new ClientRepository();
  $accessTokenRepository = new Ac
  $server = new AuthorizationServer (
        $clientRepository,
        $accessTokenRepository,
        $scopeRepository,
        $privateKeyPath,
        Key::loadFromAsciiSafeString($encryptionKey)
  );
    return $this->respond(['token' => 1234]);
  }
}