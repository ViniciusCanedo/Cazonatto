<?php

namespace App\Routes;

use App\Routes\RouteOptions;
use App\Routes\Uri;
use App\Routes\Wildcard;

class Route
{
  private ?RouteOptions $routeOptions = null;
  private ?Uri $uri = null;
  private ?Wildcard $wildcard = null;
  
  public function __construct(
    public readonly string $request,
    public readonly string $controller,
    public readonly array $wildcardAliases,
  ) {
  }

  public function addRouteGroupOptions(RouteOptions $routeOptions){
    $this->routeOptions = $routeOptions;
  }

  public function getRouteOptionsInstance(): ?RouteOptions
  {
    return $this->routeOptions;
  }

  public function addUri(Uri $uri){
    $this->uri = $uri;
  }

  public function getUriInstance(): ?Uri
  {
    return $this->uri;
  }

  public function addWildcard(Wildcard $wildcard)
  {
    $this->wildcard = $wildcard;
  }

  public function getWildcardInstance(): ?Wildcard 
  {
   return $this->wildcard;
  }

  public function match()
  {
    if($this->routeOptions->optionExist('prefix'))
    {
      $this->uri->setUri(rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri->getUri()}", "/"));
    }

    $this->wildcard->replaceWildcardWithPattern($this->uri->getUri());
    $wildcardReplaced = $this->wildcard->getWildcardReplaced();

    if($wildcardReplaced !== $this->uri->getUri() && $this->wildcard->uriEqualtoPattern($this->uri->currentUri(), $wildcardReplaced)){
      $this->uri->setUri($this->uri->currentUri());
      $this->wildcard->paramsToArray($this->uri->getUri(), $wildcardReplaced, $this->wildcardAliases);
    }

    if (
      $this->uri->getUri() === $this->uri->currentUri() &&
      strtolower($this->request) === $this->uri->currentRequest()
    ) {
      return $this;
    }
  }
}
