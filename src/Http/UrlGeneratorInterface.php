<?php
namespace GenesisGlobal\Salesforce\Http;


/**
 * Interface UrlGeneratorInterface
 * @package GenesisGlobal\Salesforce\Http
 */
interface UrlGeneratorInterface
{
    /**
     * @param null $action
     * @param null $parameters
     * @param boolean $relativeToRoot Supplied action is relative to Root path
     * @return string
     */
    public function getUrl($action = null, $parameters = null, $relativeToRoot = false);
}
