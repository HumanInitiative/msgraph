<?php

namespace humaninitiative\graph;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\Group;

trait GroupTrait
{
    /**
     * Get Microsoft 365 groups
     *
     * @param string $name Search term
     * @param int $limit Search Limit, Default to 10
     * @return Group[] List of groups
     */
    public function getGroups($name, $limit = 10)
    {
        try {
            $url = "/groups?\$top=%s&\$search=\"displayName:%s\"";
            $groups = $this->graph
                ->createRequest("GET", sprintf($url, $limit, $name))
                ->addHeaders(['ConsistencyLevel' => 'eventual'])
                ->setReturnType(Group::class)
                ->execute();
                
            return $groups;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}
