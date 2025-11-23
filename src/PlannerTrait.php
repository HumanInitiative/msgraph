<?php

namespace humaninitiative\graph;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\PlannerPlan;
use Microsoft\Graph\Model\PlannerTask;

trait PlannerTrait
{
    /**
     * Get Plans from a Microsoft 365 group by groupId
     *
     * @param string $groupId Group ID
     * @param int $limit Search Limit, Default to 10
     * @return PlannerPlan[] List of Plans
     */
    public function getPlans($groupId, $limit = 10)
    {
        try {
            $plans = $this->graph
                ->createRequest("GET", sprintf('/groups/%s/planner/plans?$top=%s', $groupId, $limit))
                ->setReturnType(PlannerPlan::class)
                ->execute();
            
            return $plans;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Tasks from a Planner plan by planId
     *
     * @param string $planId Plan ID
     * @param int $limit Search Limit, Default to 10
     * @return PlannerPlan[] List of Plans
     */
    public function getTasks($planId, $limit = 10)
    {
        try {
            $plans = $this->graph
                ->createRequest("GET", sprintf('/planner/plans/%s/tasks?$top=%s', $planId, $limit))
                ->setReturnType(PlannerTask::class)
                ->execute();
            
            return $plans;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}