<?php namespace CodeZero\Courier;

interface Courier {

    /**
     * Send GET request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param int $cacheMinutes
     *
     * @return Response
     */
    public function get($url, array $data = [], array $headers = [], $cacheMinutes = 0);

    /**
     * Send POST request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param int $cacheMinutes
     *
     * @return Response
     */
    public function post($url, array $data = [], array $headers = [], $cacheMinutes = 0);

    /**
     * Send PUT request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param int $cacheMinutes
     *
     * @return Response
     */
    public function put($url, array $data = [], array $headers = [], $cacheMinutes = 0);

    /**
     * Send PATCH request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param int $cacheMinutes
     *
     * @return Response
     */
    public function patch($url, array $data = [], array $headers = [], $cacheMinutes = 0);

    /**
     * Send DELETE request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param int $cacheMinutes
     *
     * @return Response
     */
    public function delete($url, array $data = [], array $headers = [], $cacheMinutes = 0);

    /**
     * Set basic authentication
     *
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function setBasicAuthentication($username, $password);

    /**
     * Unset basic authentication
     *
     * @return void
     */
    public function unsetBasicAuthentication();

    /**
     * Check if caching is enabled
     *
     * @return bool
     */
    public function isCacheEnabled();

    /**
     * Enable caching
     *
     * @return void
     */
    public function enableCache();

    /**
     * Disable caching
     *
     * @return void
     */
    public function disableCache();

    /**
     * Forget cached responses
     *
     * @return void
     */
    public function forgetCache();

}