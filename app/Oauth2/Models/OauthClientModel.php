<?php

namespace App\Oauth2\Models;

class OauthClientModel extends BaseModel {
  protected $table      = 'oauth2_client';
  protected $primaryKey = 'identifier';
  protected $useAutoIncrement = false;
  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = ['identifier', 'secret', 'redirect_uris', 'grants', 'scopes', 'active', 'allow_plain_text_pkce'];

  public function findBySecret($secret=NULL) {
    $this->where('secret', $secret);
    return $this->first();
  }
}