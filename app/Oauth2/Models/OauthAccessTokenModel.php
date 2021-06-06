<?php

namespace App\Oauth2\Models;

class OauthAccessTokenModel extends BaseModel {
  protected $table      = 'oauth2_access_token';
  protected $primaryKey = 'identifier';
  protected $useAutoIncrement = false;
  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = ['identifier', 'client', 'expiry', 'user_identifier', 'scopes', 'revoked'];
}