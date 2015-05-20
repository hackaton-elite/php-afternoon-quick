<?php


namespace CoreBundle\Service;


use CoreBundle\Entity\Point;

class LeeService
{
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
     * @var Point
     */
    protected $endPoint;

    public function findRoute(Point $startPoint, Point $endPoint)
    {
        $this->endPoint = $endPoint;

        /* Create map copy */
        $this->solvedMap = $this->createInitialSolvedMap($this->obstacleMap);
        $this->solvedMap = $this->markStartNodeAsVisited($this->solvedMap, $startPoint);
        $this->displayMap($this->obstacleMap);
        $this->displayMap($this->solvedMap);

        $this->visitNode($startPoint->getXCoordinate(), $startPoint->getYCoordinate());

//        var_dump($this->mapWidth);
//        var_dump($this->mapHeight);
//        die;

        $this->displayMap($this->solvedMap);

        var_dump($this->bestSolutionLength);

        foreach ($this->bestSolutionRoute as $bestSolutionStep) {
            echo $bestSolutionStep . ", ";
        }
    }

    public function visitNode($xCoordinate, $yCoordinate, $bestSolutionSoFar = [])
    {
        if ($xCoordinate < 0 || $xCoordinate > $this->mapHeight - 1 || $yCoordinate < 0 || $yCoordinate > $this->mapWidth - 1 || $this->solvedMap[$xCoordinate][$yCoordinate] === 'y' || $this->obstacleMap[$xCoordinate][$yCoordinate] === 'x') {
            return;
        }

        $this->obstacleMap[$xCoordinate][$yCoordinate] = 'x';
        $currentValue                                  = $this->solvedMap[$xCoordinate][$yCoordinate];

        if ($currentValue >= $this->bestSolutionLength) {
            return;
        }

        $newValue            = $currentValue + 1;
        $bestSolutionSoFar[] = new Point($xCoordinate, $yCoordinate);

        $this->visitNeighbour($xCoordinate + 1, $yCoordinate, $newValue, $bestSolutionSoFar);
        $this->visitNeighbour($xCoordinate - 1, $yCoordinate, $newValue, $bestSolutionSoFar);
        $this->visitNeighbour($xCoordinate, $yCoordinate + 1, $newValue, $bestSolutionSoFar);
        $this->visitNeighbour($xCoordinate, $yCoordinate - 1, $newValue, $bestSolutionSoFar);

        $this->visitNode($xCoordinate + 1, $yCoordinate, $bestSolutionSoFar);
        $this->visitNode($xCoordinate - 1, $yCoordinate, $bestSolutionSoFar);
        $this->visitNode($xCoordinate, $yCoordinate + 1, $bestSolutionSoFar);
        $this->visitNode($xCoordinate, $yCoordinate - 1, $bestSolutionSoFar);
    }

    public function visitNeighbour($xCoordinate, $yCoordinate, $newValue, $bestSolutionSoFar)
    {
        if ($xCoordinate < 0 || $xCoordinate > $this->mapHeight - 1 || $yCoordinate < 0 || $yCoordinate > $this->mapWidth - 1) {
            return;
        }

        $currentValue = $this->solvedMap[$xCoordinate][$yCoordinate];

        if ((0 === $currentValue || $currentValue > $newValue) && $currentValue !== 'y') {
            $this->solvedMap[$xCoordinate][$yCoordinate] = $newValue;

            if ($xCoordinate === $this->endPoint->getXCoordinate() && $yCoordinate === $this->endPoint->getYCoordinate() && $this->bestSolutionLength > $newValue) {
                $this->bestSolutionLength = $newValue;
                $bestSolutionSoFar[]      = new Point($xCoordinate, $yCoordinate);
                $this->bestSolutionRoute  = $bestSolutionSoFar;
            }
        }
    }

    public function markStartNodeAsVisited($map, $startPoint)
    {
        $map[$startPoint->getXCoordinate()][$startPoint->getYCoordinate()] = 1;

        return $map;
    }

    public function createInitialSolvedMap($map)
    {
        $solvedMap       = [];
        $this->mapHeight = count($map);

        foreach ($map as $mapLine => $mapLineContent) {
            $solvedMap[$mapLine] = [];
            $this->mapWidth      = count($mapLineContent);

            foreach ($mapLineContent as $mapColumnKey => $mapColumn) {
                if (0 !== $mapColumn) {
                    $solvedMap[$mapLine][$mapColumnKey] = 'y';
                } else {
                    $solvedMap[$mapLine][$mapColumnKey] = 0;
                }
            }
        }

        return $solvedMap;
    }

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
}
