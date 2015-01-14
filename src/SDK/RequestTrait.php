<?php
/**
 * @file
 * Contains RequestTrait.php.
 */

namespace Acquia\Cloud\Api\SDK;


use GuzzleHttp\Client;

trait RequestTrait {

  /**
   * @param $url
   * @return \GuzzleHttp\Message\ResponseInterface
   * @throws \Exception
   */
  protected function request($url, array $options = []) {
    $request = $this->client()->get($url, $options);
    if (!is_object($request)) {
      var_export($request);
    }
    if ($request->getStatusCode() != 200) {
      throw new \Exception(sprintf('Status code was not OK. %d returned instead.', $request->getStatusCode()));
    }
    return $request;
  }

  /**
   * Statically stores and returns a guzzle client.
   *
   * The Guzzle client is quite large and we really don't want to deal with it
   * during debugging, so we store it statically in a method to hide it away.
   *
   * @param \GuzzleHttp\Client $new_client
   *
   * @return \GuzzleHttp\Client
   */
  protected function client(Client $new_client = NULL) {
    static $client;
    if (!is_null($new_client)) {
      $client = $new_client;
    }
    return $client;
  }
} 