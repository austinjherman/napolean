<?php

namespace Scsmktng\Napolean;

use Scsmktng\Napolean\Page;

class Application {

  public $basePath;
  public $baseUrl;

  /**
   * Application Constructor
   * base path relative to the installation directory 
   * base url returns root url
   *
   * @param void
   * @return void
   */
  public function __construct($installationDirectory) {
    $this->basePath = dirname($_SERVER['SCRIPT_FILENAME']);
    $this->baseUrl = $installationDirectory === '/' || '' ? $this->getProtocol() . $_SERVER['HTTP_HOST'] : $this->getProtocol() . $_SERVER['HTTP_HOST'] . $installationDirectory;
  }

  /**
   * Page Renderer
   *
   * @param String $pageName the name of the template (without .php)
   * @return TODO
   */
  public function renderPage($pageName) {
    $pageDir = $this->basePath . '/pages';
    if (is_file($pageDir . '/' . $pageName . '.php')) {
      $page = new Page($this, $pageDir . '/' . $pageName . '.php');
      $page->fillBag();
      $this->renderTemplate($page);
    }
    return false;
  }

  /**
   * Template Renderer
   *
   * @param Page $page the found page object
   * @return TODO
   */
  public function renderTemplate(Page $page) {
    $templateDir = $this->basePath . '/views/templates';
    $template = $page->get('template');
    if (!$template) {
      $template = 'default';
    }
    if (is_file($templateDir . '/' . $template . '.php')) {
      include_once($templateDir . '/' . $template . '.php');
    }
    return false;
  }

  /**
   * Get Protocol
   * Get the server's default protocol
   *
   * @param void
   * @return String "http://" or "https://"
   */
  protected function getProtocol() {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  }

}