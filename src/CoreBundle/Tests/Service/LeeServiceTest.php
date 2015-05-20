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
    public function testFindRoute($map, $startPoint, $endPoint)
    {
        $this->leeService->setObstacleMap($map);

        $route = $this->leeService->findRoute($startPoint, $endPoint);
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

        $firstStartPoint = new Point(0, 0);
        $firstEndPoint   = new Point(4, 4);

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

        $secondStartPoint = new Point(0, 0);
        $secondEndPoint = new Point (7, 2);

        return [
            [$firstMap, $firstStartPoint, $firstEndPoint],
            [$secondMap, $secondStartPoint, $secondEndPoint],
        ];
    }
}
