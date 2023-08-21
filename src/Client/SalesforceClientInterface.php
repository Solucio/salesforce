<?php
namespace GenesisGlobal\Salesforce\Client;

/**
 * Interface SalesforceClientInterface
 * @package GenesisGlobal\Salesforce\Client
 */
interface SalesforceClientInterface
{
    /**
     * @param string $action
     * @param null $query
     * @param boolean $relativeToRoot Supplied action is relative to Root path
     * @return ResponseInterface
     */
    public function get($action = null, $query = null, $relativeToRoot = false);

    /**
     * @param string $action
     * @param null $query
     * @return mixed
     */
    public function getApex($action = null, $query = null);

    /**
     * @param string|null $action
     * @param null $query
     * @param null $data
     * @return mixed
     */
    public function post($action = null, $data = null, $query = null);

    /**
     * @param string|null $action
     * @param null $query
     * @param null $data
     * @return mixed
     */
    public function postApex($action = null, $data = null, $query = null);

    /**
     * @param string|null $action
     * @param null $query
     * @param null $data
     * @param array $headers
     * @return mixed
     */
    public function patch($action = null, $data = null, $query = null, $headers = []);
}
