<?php


namespace CoreBundle\Tests\Service;


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
     * @param $map
     * @param $startPoint
     * @param $endPoint
     *
     * @dataProvider findRouteDataProvider
     */
    public function testFindRoute($map, $startPoint, $endPoint, $expectedLength)
    {
        $this->leeService->setObstacleMap($map);
        $route = $this->leeService->findRoute($startPoint, $endPoint);

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

        $firstStartPoint     = new Point(0, 0);
        $firstEndPoint       = new Point(4, 4);
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

        $secondStartPoint     = new Point(0, 0);
        $secondEndPoint       = new Point (7, 2);
        $secondExpectedLength = 22;

        $impossibleMap = [
            [0, 0, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 0],
        ];

        $impossibleMapStartPoint = new Point(0, 0);
        $impossibleMapEndPoint   = new Point(3, 3);
        $impossibleMapLength     = 0;

        $nextToEachOtherMap = [
            [0, 0, 0],
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
            [0, 0, 0],
        ];

        $nextToEachOtherStartPoint = new Point(5, 0);
        $nextToEachOtherEndPoint   = new Point(5, 2);
        $nextToEachOtherLength     = 3;

        return [
            [$firstMap, $firstStartPoint, $firstEndPoint, $firstExpectedLength],
            [$secondMap, $secondStartPoint, $secondEndPoint, $secondExpectedLength],
            [$impossibleMap, $impossibleMapStartPoint, $impossibleMapEndPoint, $impossibleMapLength],
            [$nextToEachOtherMap, $nextToEachOtherStartPoint, $nextToEachOtherEndPoint, $nextToEachOtherLength],
        ];
    }
}
