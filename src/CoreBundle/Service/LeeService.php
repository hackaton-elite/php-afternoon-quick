<?php


namespace CoreBundle\Service;


use ApiBundle\Entity\EndLocation;
use ApiBundle\Entity\StartLocation;
use CoreBundle\Entity\Point;

/**
 * Generate a solution to the map path problem using Lee's algorithm.
 *
 * @package CoreBundle\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class LeeService
{
    const OBSTACLE_MARK = 'y';
    const NODE_VISITED_MARK = 'x';

    /**
     * @var array
     */
    protected $obstacleMap;

    /**
     * @var array
     */
    protected $solvedMap;

    /**
     * @var int
     */
    protected $mapWidth;

    /**
     * @var int
     */
    protected $mapHeight;

    /**
     * @var int
     */
    protected $bestSolutionLength = PHP_INT_MAX;

    /**
     * @var array
     */
    protected $bestSolutionRoute = [];

    /**
     * @var EndLocation
     */
    protected $endPoint;

    public function findRoute($obstacleMap, StartLocation $startPoint, EndLocation $endPoint)
    {
        $this->obstacleMap = $obstacleMap;
        $this->setEndPoint($endPoint);

        /* Create map copy */
        $this->solvedMap = $this->createInitialSolvedMapAndMarkObstacles($this->obstacleMap);
        $this->solvedMap = $this->markStartNodeAsVisited($this->solvedMap, $startPoint);

        $this->visitNode($startPoint->getXCoordinate(), $startPoint->getYCoordinate());

        if (PHP_INT_MAX !== $this->bestSolutionLength) {
            $endPoint = new Point($this->endPoint->getXCoordinate(), $this->endPoint->getYCoordinate());
            $this->bestSolutionRoute = $this->retrieveBestSolutionRoute($endPoint);
        }

        return $this->bestSolutionRoute;
    }

    protected function retrieveBestSolutionRoute(Point $point, array $bestRoute = [])
    {
        $bestRoute[] = $point;

        if (1 === $this->getPointValue($point)) {
            return $bestRoute;
        }

        /* Check neighbours */
        $lowestNeighbour = $this->findLowestNeighbour($point);

        /* Recursive call bellow */

        return $this->retrieveBestSolutionRoute($lowestNeighbour, $bestRoute);
    }

    protected function findLowestNeighbour(Point $point)
    {
        $xCoordinate = $point->getXCoordinate();
        $yCoordinate = $point->getYCoordinate();

        $topNeighbourPosition    = new Point($xCoordinate - 1, $yCoordinate);
        $bottomNeighbourPosition = new Point($xCoordinate + 1, $yCoordinate);
        $leftNeighbourPosition   = new Point($xCoordinate, $yCoordinate - 1);
        $rightNeighbourPosition  = new Point($xCoordinate, $yCoordinate + 1);

        $topNeighbourScore    = $this->getPointValue($topNeighbourPosition);
        $bottomNeighbourScore = $this->getPointValue($bottomNeighbourPosition);
        $leftNeighbourScore   = $this->getPointValue($leftNeighbourPosition);
        $rightNeighbourScore  = $this->getPointValue($rightNeighbourPosition);

        $neigbours = [
            [
                'position' => $topNeighbourPosition,
                'score'    => $topNeighbourScore
            ],
            [
                'position' => $bottomNeighbourPosition,
                'score'    => $bottomNeighbourScore
            ],
            [
                'position' => $leftNeighbourPosition,
                'score'    => $leftNeighbourScore
            ],
            [
                'position' => $rightNeighbourPosition,
                'score'    => $rightNeighbourScore,
            ],
        ];

        $lowestScore    = $topNeighbourScore;
        $lowestPosition = $topNeighbourPosition;

        foreach ($neigbours as $neighbour) {
            if ($neighbour['score'] < $lowestScore) {
                $lowestScore    = $neighbour['score'];
                $lowestPosition = $neighbour['position'];
            }
        }

        return $lowestPosition;
    }

    protected function getPointValue(Point $point)
    {
        if (!$this->nodeIsOutOfBounds($point->getXCoordinate(), $point->getYCoordinate())
            && $this->nodeHasBeenPreviouslyVisited($point->getXCoordinate(), $point->getYCoordinate())
        ) {
            return $this->solvedMap[$point->getXCoordinate()][$point->getYCoordinate()];
        }

        return PHP_INT_MAX;
    }

    public function visitNode($xCoordinate, $yCoordinate)
    {
        /* Don't bother visiting if node is out of bounds, an obstacle, or previously visited.*/
        if ($this->nodeIsOutOfBounds($xCoordinate, $yCoordinate)
            || $this->nodeIsObstacle($xCoordinate, $yCoordinate)
            || $this->nodeHasBeenPreviouslyVisited($xCoordinate, $yCoordinate)
        ) {
            return;
        }

        /* Mark that the node has been visited. */
        $this->obstacleMap[$xCoordinate][$yCoordinate] = self::NODE_VISITED_MARK;

        /* Get the best path that has been accessed so far. */
        $currentValue = $this->solvedMap[$xCoordinate][$yCoordinate];

        /* If we already have a better solution, don't bother going further. */
        if ($currentValue >= $this->bestSolutionLength) {
            return;
        }

        $newValue = $currentValue + 1;

        /* Get the optimal path to all the neighbours. */
        $this->visitNeighbour($xCoordinate + 1, $yCoordinate, $newValue);
        $this->visitNeighbour($xCoordinate - 1, $yCoordinate, $newValue);
        $this->visitNeighbour($xCoordinate, $yCoordinate + 1, $newValue);
        $this->visitNeighbour($xCoordinate, $yCoordinate - 1, $newValue);


        /* Visit the neighbours and carry on generating best path. */
        $this->visitNode($xCoordinate + 1, $yCoordinate);
        $this->visitNode($xCoordinate - 1, $yCoordinate);
        $this->visitNode($xCoordinate, $yCoordinate + 1);
        $this->visitNode($xCoordinate, $yCoordinate - 1);
    }

    /**
     * Display a map - used mainly during debugging for some visual aid.
     *
     * @param array $map
     *
     * @return string
     */
    public function displayMap($map)
    {
        echo PHP_EOL;
        foreach ($map as $mapLine) {
            foreach ($mapLine as $mapColumn) {
                echo $mapColumn . "\t";
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function visitNeighbour($xCoordinate, $yCoordinate, $newValue)
    {
        if ($this->nodeIsOutOfBounds($xCoordinate, $yCoordinate)) {
            return;
        }

        $currentValue = $this->solvedMap[$xCoordinate][$yCoordinate];

        if ((0 === $currentValue || $currentValue > $newValue) && $currentValue !== self::OBSTACLE_MARK) {
            $this->solvedMap[$xCoordinate][$yCoordinate] = $newValue;

            if ($xCoordinate === $this->endPoint->getXCoordinate() && $yCoordinate === $this->endPoint->getYCoordinate() && $this->bestSolutionLength > $newValue) {
                $this->bestSolutionLength = $newValue;
            }
        }
    }

    public function markStartNodeAsVisited($map, $startPoint)
    {
        $map[$startPoint->getXCoordinate()][$startPoint->getYCoordinate()] = 1;

        return $map;
    }

    public function createInitialSolvedMapAndMarkObstacles($map)
    {
        $solvedMap = [];

        /* Compute map height. */
        $this->mapHeight = count($map);

        foreach ($map as $mapLine => $mapLineContent) {
            $solvedMap[$mapLine] = [];

            /* Compute map width. */
            if (null === $this->mapWidth) {
                $this->mapWidth = count($mapLineContent);
            }

            foreach ($mapLineContent as $mapColumnKey => $mapColumn) {
                /* If the map has an obstacle on it, mark it in a special way. */
                if (0 !== $mapColumn) {
                    $solvedMap[$mapLine][$mapColumnKey] = self::OBSTACLE_MARK;
                } else {
                    $solvedMap[$mapLine][$mapColumnKey] = 0;
                }
            }
        }

        return $solvedMap;
    }

    /**
     * Check if a node is out of bounds.
     *
     * @param int $xCoordinate
     * @param int $yCoordinate
     *
     * @return bool
     */
    protected function nodeIsOutOfBounds($xCoordinate, $yCoordinate)
    {
        return $xCoordinate < 0 || $xCoordinate > $this->mapHeight - 1 || $yCoordinate < 0 || $yCoordinate > $this->mapWidth - 1;
    }

    /**
     * Check if a node is an obstacle.
     *
     * @param int $xCoordinate
     * @param int $yCoordinate
     *
     * @return bool
     */
    protected function nodeIsObstacle($xCoordinate, $yCoordinate)
    {
        return self::OBSTACLE_MARK === $this->solvedMap[$xCoordinate][$yCoordinate];
    }

    /**
     * Check if a node has been previously visited.
     *
     * @param int $xCoordinate
     * @param int $yCoordinate
     *
     * @return bool
     */
    protected function nodeHasBeenPreviouslyVisited($xCoordinate, $yCoordinate)
    {
        return self::NODE_VISITED_MARK === $this->obstacleMap[$xCoordinate][$yCoordinate];
    }

    /**
     * @return array
     */
    public function getObstacleMap()
    {
        return $this->obstacleMap;
    }

    /**
     * @param array $obstacleMap
     *
     * @return $this
     */
    public function setObstacleMap($obstacleMap)
    {
        $this->obstacleMap = $obstacleMap;

        return $this;
    }

    /**
     * @return array
     */
    public function getSolvedMap()
    {
        return $this->solvedMap;
    }

    /**
     * @param array $solvedMap
     *
     * @return $this
     */
    public function setSolvedMap($solvedMap)
    {
        $this->solvedMap = $solvedMap;

        return $this;
    }

    /**
     * @return int
     */
    public function getMapWidth()
    {
        return $this->mapWidth;
    }

    /**
     * @param int $mapWidth
     *
     * @return $this
     */
    public function setMapWidth($mapWidth)
    {
        $this->mapWidth = $mapWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getMapHeight()
    {
        return $this->mapHeight;
    }

    /**
     * @param int $mapHeight
     *
     * @return $this
     */
    public function setMapHeight($mapHeight)
    {
        $this->mapHeight = $mapHeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getBestSolutionLength()
    {
        return $this->bestSolutionLength;
    }

    /**
     * @param int $bestSolutionLength
     *
     * @return $this
     */
    public function setBestSolutionLength($bestSolutionLength)
    {
        $this->bestSolutionLength = $bestSolutionLength;

        return $this;
    }

    /**
     * @return array
     */
    public function getBestSolutionRoute()
    {
        return $this->bestSolutionRoute;
    }

    /**
     * @param array $bestSolutionRoute
     *
     * @return $this
     */
    public function setBestSolutionRoute($bestSolutionRoute)
    {
        $this->bestSolutionRoute = $bestSolutionRoute;

        return $this;
    }

    /**
     * @return EndLocation
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @param EndLocation $endPoint
     *
     * @return $this
     */
    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;

        return $this;
    }


}
