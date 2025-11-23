<?php

namespace humaninitiative\graph;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\Team;

trait TeamsTrait
{
    /**
     * Get Microsoft 365 Teams
     *
     * @param string $userId User ID
     * @param string $name Search term
     * @param int $limit Search Limit, Default to 10
     * @return Team[] List of Teams
     */
    public function getTeams($userId, $search = null, $limit = 10)
    {
        try {
            $url = sprintf('/users/%s/joinedTeams?$top=%s', $userId, $limit);
            if ($search) {
                $url = sprintf('/users/%s/joinedTeams?$top=%s&$search=\"displayName:%s\"', $userId, $limit, $search);
            }
    
            $teams = $this->graph
                ->createRequest("GET", $url)
                ->addHeaders(['ConsistencyLevel' => 'eventual'])
                ->setReturnType(Team::class)
                ->execute();
            
            return $teams;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}
