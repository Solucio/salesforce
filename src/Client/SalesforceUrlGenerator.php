<?php
namespace GenesisGlobal\Salesforce\Client;

use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;

/**
 * Class SalesforceUrlGenerator
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceUrlGenerator implements UrlGeneratorInterface
{

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * SalesforceUrlGenerator constructor.
     * @param $endpoint
     * @param $version
     */
    public function __construct($endpoint, $version)
    {
        $this->endpoint = $endpoint;
        $this->version = $version;
    }

    /**
     * @param null $action
     * @param null $parameters
     * @param boolean $relativeToRoot Supplied action is relative to Root path
     * @return string
     */
    public function getUrl($action = null, $parameters = null, $relativeToRoot = false)
    {
        $url = $this->getBasePath($relativeToRoot);
        if ($action) {
            // make sure action doesn't have forwarding slash
            $url = $url . ltrim($action, "/");
        }
        $url = $this->addParameters($url, $parameters);

        return $url;
    }

    /**
     * @param null $action
     * @param null $parameters
     * @return string
     */
    public function getUrlApex($action = null, $parameters = null)
    {
        $url = $this->getBasePathApex();
        if ($action) {
            // make sure action doesn't have forwarding slash
            $url = $url . ltrim($action, "/");
        }
        $url = $this->addParameters($url, $parameters);

        return $url;
    }

    /**
     * @param boolean $relativeToRoot Supplied action is relative to Root path
     * @return string
     */
    public function getBasePath($relativeToRoot = false)
    {
        // make sure we got only one slash there :)
        $basePath = rtrim($this->endpoint, "/");

        if (!$relativeToRoot) {
            $basePath .= '/services/data/' . $this->version;
        }

        $basePath .= '/';

        return $basePath;
    }

    /**
     * @return string
     */
    public function getBasePathApex()
    {
        // make sure we got only one slash there :)
        return rtrim($this->endpoint, "/") . '/services/apexrest/';
    }

    /**
     * @param $path
     * @param $parameters
     * @return string
     */
    protected function addParameters($path, $parameters)
    {
        if ($parameters && is_array($parameters)) {
            $glue = '?';
            foreach ($parameters as $key => $value) {
                //$path .= $glue . $key . '=' . strtr($value, ' ', '+');
                $path .= $glue . $key . '=' . urlencode($value);
                $glue = '&';
            }
        }
        return $path;
    }
}
