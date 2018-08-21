<?php

namespace Scsmktng\Napolean;

use Scsmktng\Napolean\Application;

class Page {

  private $filePath;

  public function __construct(Application $app, $filePath) {
    $this->app = $app;
    $this->filePath = $filePath;
    $this->bag = array();
  }

  public function fillBag() {
    $page = $this;
    ob_start();
    require($this->filePath);
    if (isset($fields)) {
      foreach ($fields as $key => $value) {
        $this->bag[$key] = $value;
      }
    }
    $this->bag['content'] = ob_get_clean();
  }

  public function get($property) {
    if (isset($this->bag[$property])) {
      return $this->bag[$property];
    }
    return null;
  }

  public function link($path) {
    return $this->app->baseUrl . $path;
  }

  public function siteUrl() {
    return $this->app->baseUrl;
  }

  public function getPartial($path) {
    $page = $this;
    $partialDir = $this->app->basePath . '/views/partials';
    if (is_file($partialDir . '/' . $path . '.php')) {
      include $partialDir . '/' . $path . '.php';
      return true;
    }
    return false;
  }

}