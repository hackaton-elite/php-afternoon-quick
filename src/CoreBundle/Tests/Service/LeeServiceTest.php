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

    public function testFindRoute()
    {
        $map = [
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0],
            [1, 0, 0, 0, 0],
        ];

        $startPoint = new Point(0, 0);
        $endPoint   = new Point(5, 5);

        $this->leeService->setObstacleMap($map);

        $route = $this->leeService->findRoute($startPoint, $endPoint);
    }
}
