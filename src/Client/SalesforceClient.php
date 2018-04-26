<?php
namespace GenesisGlobal\Salesforce\Client;

use GenesisGlobal\Salesforce\Authentication\AuthenticatorInterface;
use GenesisGlobal\Salesforce\Http\Exception\BadResponseException;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\Response\ResponseCreatorInterface;
use GenesisGlobal\Salesforce\Http\Response\ResponseInterface;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;

/**
 * Class SalesforceClient
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceClient implements SalesforceClientInterface
{
    /**
     * Content of body type json
     */
    const BODY_TYPE_JSON = 'application/json';

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var AuthenticatorInterface
     */
    protected $authenticator;

    /**
     * @var ResponseCreatorInterface
     */
    protected $responseCreator;

    /**
     * SalesforceClient constructor.
     * @param HttpClientInterface $httpClient
     * @param UrlGeneratorInterface $urlGenerator
     * @param AuthenticatorInterface $authenticator
     * @param ResponseCreatorInterface $responseCreator
     */
    public function __construct(
        HttpClientInterface $httpClient,
        UrlGeneratorInterface $urlGenerator,
        AuthenticatorInterface $authenticator,
        ResponseCreatorInterface $responseCreator
    ) {

        $this->httpClient = $httpClient;
        $this->urlGenerator = $urlGenerator;
        $this->authenticator = $authenticator;
        $this->responseCreator = $responseCreator;
    }

    /**
     * @param string $action
     * @param null $query
     * @param boolean $relativeToRoot Supplied action is relative to Root path
     * @return ResponseInterface
     */
    public function get($action = null, $query = null, $relativeToRoot = false)
    {
        try {
            //die($this->urlGenerator->getUrl($action, $this->resolveParams($query)));
            $salesforceResponse = $this->httpClient->get(
                $this->urlGenerator->getUrl($action, $this->resolveParams($query), $relativeToRoot),
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($salesforceResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param string $action
     * @param null $query
     * @return ResponseInterface
     */
    public function getApex($action = null, $query = null)
    {
        try {
            //die($this->urlGenerator->getUrl($action, $this->resolveParams($query)));
            $salesforceResponse = $this->httpClient->get(
                $this->urlGenerator->getUrlApex($action, $this->resolveParams($query)),
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($salesforceResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function post($action = null, $data = null, $query = null)
    {
        try {
            $httpResponse = $this->httpClient->post(
                $this->urlGenerator->getUrl($action, $this->resolveParams($query)),
                $data,
                self::BODY_TYPE_JSON,
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($httpResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function postApex($action = null, $data = null, $query = null)
    {
        try {
            $httpResponse = $this->httpClient->post(
                $this->urlGenerator->getUrlApex($action, $this->resolveParams($query)),
                $data,
                self::BODY_TYPE_JSON,
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($httpResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function patch($action = null, $data = null, $query = null)
    {
        try {
            $httpResponse = $this->httpClient->patch(
                $this->urlGenerator->getUrl($action, $this->resolveParams($query)),
                $data,
                self::BODY_TYPE_JSON,
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($httpResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function patchApex($action = null, $data = null, $query = null)
    {
        try {
            $httpResponse = $this->httpClient->patch(
                $this->urlGenerator->getUrlApex($action, $this->resolveParams($query)),
                $data,
                self::BODY_TYPE_JSON,
                ['headers' => $this->getAuthorizationHeaders()]
            );
            return $this->responseCreator->create($httpResponse);
        } catch (BadResponseException $e) {
            // we return Response with success=false
            return $this->responseCreator->create($e->getResponse());
        }
    }

    /**
     * @param $query
     * @return array|null
     */
    protected function resolveParams($query)
    {
        $params = null;
        if ($query) {
            $params = ['q' => $query];
        }
        return $params;
    }

    /**
     * @return array
     */
    protected function getAuthorizationHeaders()
    {
        return [
            'Authorization' => 'OAuth ' . $this->authenticator->getAccessToken()
        ];
    }
}
