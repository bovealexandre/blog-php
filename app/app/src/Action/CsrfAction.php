<?php

namespace App\Action;

use Slim\Csrf\Guard;

class CsrfAction extends \Twig_Extension{

  protected $guard;

  public function __construct(Guard $guard){
    $this->guard=$guard;
  }

  public function getFunctions(){
    return [
      new \Twig_SimpleFunction('csrf_fields', array($this, 'csrfFields'))
    ];
  }

  public function csrfFields(){
    return '
      <input type="hidden" name="'. $this->guard->getTokenNameKey() .'" value="'. $this->guard->getTokenName() .'">
      <input type="hidden" name="'. $this->guard->getTokenValueKey() .'" value="'. $this->guard->getTokenValue() .'">
    ';
  }
}