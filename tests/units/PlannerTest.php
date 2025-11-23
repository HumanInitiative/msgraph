<?php

use humaninitiative\graph\Connection;
use Microsoft\Graph\Model\Group;
use Microsoft\Graph\Model\Team;
use PHPUnit\Framework\TestCase;

final class PlannerTest extends TestCase
{
    /** @var Connection $connection */
    protected $connection;

    protected function setUp(): void
    {
        require_once './fn.php';
        load_env();

        $this->connection = new Connection($_ENV['WEB_TOKEN']);
    }

    public function testListPlans(): void
    {
        $teams = $this->connection->getTeams($_ENV['USER_ITDEV_ID']);

        var_dump(array_map(function (Team $team) {
            return ['id' => $team->getId(), 'name' => $team->getDisplayName()];
        }, $teams));
    }
}
