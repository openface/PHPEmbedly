<?php
require_once "HTTP/Request.php";

class Embedly {

  private $url = "";
  private $params = Array();

  private $request_url = "";
  private $request = null;
  private $response = "";
  private $responseBody = "";

  public function __construct($url, $params=null) {
    $this->url = $url;

    $this->params = $params;
    $this->params['format'] = isset($params['format']) ? $params['format'] : 'json';
    $this->params['maxwidth'] = isset($params['maxwidth']) ? $params['maxwidth'] : null;
    $this->params['maxheight'] = isset($params['maxheight']) ? $params['maxheight'] : null;

    $this->createRequest();
    $this->sendRequest();
  }

  public function getResponse() {
    return $this->responseBody;
  }

  private function createRequest() {
    $api_url = 'http://api.embed.ly/v1/api/oembed';
    $this->request_url = "{$api_url}?url={$this->url}";
    if (!empty($this->params)) {
      foreach ($this->params AS $key=>$value) {
        if (!empty($value)) $this->request_url .= "&{$key}={$value}";
      }
    }
    $this->request =& new HTTP_Request($this->request_url);
    #if (!empty($this->params['username']) && !empty($this->params['password'])) {
    #  $this->request->setBasicAuth($this->params['username'], $this->params['password']);
    #}        
    $this->request->setMethod(HTTP_REQUEST_METHOD_GET);
  }

  private function sendRequest() {
    $this->response = $this->request->sendRequest();

    if (PEAR::isError($this->response)) {
      throw new Exception($this->response->getMessage());
    } else {
      $this->responseBody = $this->request->getResponseBody();
    }
  }

}

?>
