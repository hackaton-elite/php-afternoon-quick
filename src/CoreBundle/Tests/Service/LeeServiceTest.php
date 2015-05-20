<?php


namespace CoreBundle\Tests\Service;


use ApiBundle\Entity\EndLocation;
use ApiBundle\Entity\StartLocation;
use CoreBundle\Entity\Point;
use CoreBundle\Service\LeeService;
use CoreBundle\Tests\AbstractIntegrationTest;

class LeeServiceTest extends AbstractIntegrationTest
{
    /**
     * @var LeeService
     */
    protected $leeService;

    public function setUp()
    {
        parent::setUp();

        $this->leeService = $this->getContainer()->get('core.lee.service');
    }

    /**
     * @param array $map
     * @param StartLocation $startPoint
     * @param EndLocation $endPoint
     *
     * @dataProvider findRouteDataProvider
     */
    public function testFindRoute($map, $startPoint, $endPoint, $expectedLength)
    {
        $this->leeService->setObstacleMap($map);
        $route = $this->leeService->findRoute($map, $startPoint, $endPoint);

        $this->assertNotNull($route);
        $this->assertInternalType('array', $route);
        $this->assertCount($expectedLength, $route);
    }

    public function findRouteDataProvider()
    {
        $firstMap = [
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [1, 0, 0, 0, 0],
        ];

        $firstStartPoint     = new StartLocation(0, 0);
        $firstEndPoint       = new EndLocation(4, 4);
        $firstExpectedLength = 9;

        $secondMap = [
            [0, 0, 0, 0, 0],
            [1, 1, 1, 1, 0],
            [0, 0, 0, 0, 0],
            [0, 1, 1, 1, 1],
            [0, 0, 0, 0, 0],
            [1, 1, 1, 1, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
        ];

        $secondStartPoint     = new StartLocation(0, 0);
        $secondEndPoint       = new EndLocation(7, 2);
        $secondExpectedLength = 22;

        $impossibleMap = [
            [0, 0, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 0],
        ];

        $impossibleMapStartPoint = new StartLocation(0, 0);
        $impossibleMapEndPoint   = new EndLocation(3, 3);
        $impossibleMapLength     = 0;

        $nextToEachOtherMap = [
            [0, 0, 0],
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
            [0, 0, 0],
        ];

        $nextToEachOtherStartPoint = new StartLocation(5, 0);
        $nextToEachOtherEndPoint   = new EndLocation(5, 1);
        $nextToEachOtherLength     = 2;

        $highStepCountBugMap = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [1, 0, 1, 0, 0],
            [0, 1, 0, 1, 0],
        ];

        $highStepCountBugStartPoint = new StartLocation(0, 0);
        $highStepCountBugEndPoint = new EndLocation(4, 4);
        $highStepCountBugExpectedLength = 9;

        return [
            [$firstMap, $firstStartPoint, $firstEndPoint, $firstExpectedLength],
            [$secondMap, $secondStartPoint, $secondEndPoint, $secondExpectedLength],
            [$impossibleMap, $impossibleMapStartPoint, $impossibleMapEndPoint, $impossibleMapLength],
            [$nextToEachOtherMap, $nextToEachOtherStartPoint, $nextToEachOtherEndPoint, $nextToEachOtherLength],
            [$highStepCountBugMap, $highStepCountBugStartPoint, $highStepCountBugEndPoint, $highStepCountBugExpectedLength],
        ];
    }
}
