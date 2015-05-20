<?php


namespace ApiBundle\Service;


use ApiBundle\Entity\Maze;
use ApiBundle\Entity\MazePoint;
use ApiBundle\Entity\StartLocation;

class MazeService extends AbstractEntityManagerService
{
    /**
     * @param Maze $maze
     *
     * @return Maze
     */
    public function generateNewMaze(Maze $maze)
    {
        $startPoint = $maze->getStartLocation();
        $endPoint   = $maze->getEndLocation();

        for ($heightIterator = 0; $heightIterator < $maze->getHeight(); $heightIterator++) {
            for ($widthIterator = 0; $widthIterator < $maze->getWidth(); $widthIterator++) {
                $mazePointIsObstacle = false;

                if (!($startPoint->getXCoordinate() === $heightIterator && $startPoint->getYCoordinate() === $widthIterator)
                    && !($endPoint->getXCoordinate() === $heightIterator && $endPoint->getYCoordinate() === $widthIterator)
                ) {
                    $randomNumber        = rand(0, 100);
                    $mazePointIsObstacle = $randomNumber <= $maze->getBrickDensity();
                }


                $mazePoint = new MazePoint();

                $mazePoint
                    ->setMaze($maze)
                    ->setObstacle($mazePointIsObstacle)
                    ->setXCoordinate($heightIterator)
                    ->setYCoordinate($widthIterator);

                $this->getManager()->persist($mazePoint);
                $maze->addMazePoint($mazePoint);
            }
        }

        $this->getManager()->flush();

        return $maze;
    }

    /**
     * @param Maze $maze
     *
     * @return array
     */
    public function getMazeAsArray(Maze $maze)
    {
        $mapAsArray = [];

        for ($heightIterator = 0; $heightIterator < $maze->getHeight(); $heightIterator++) {
            $mapAsArray[$heightIterator] = [];
        }

        /** @var MazePoint $mazePoint */
        foreach ($maze->getMazePoints() as $mazePoint) {
            $pointXCoordinate = $mazePoint->getXCoordinate();
            $pointYCoordinate = $mazePoint->getYCoordinate();

            $mapAsArray[$pointXCoordinate][$pointYCoordinate] = $mazePoint->isObstacle();
        }

        return $mapAsArray;
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
        $output = '';

        $output .= PHP_EOL;
        foreach ($map as $mapLine) {
            foreach ($mapLine as $mapColumn) {
                $output .= (false === $mapColumn) ? 'x' : ' ';
            }
            $output .= PHP_EOL;
        }
        $output .= PHP_EOL;

        return $output;
    }

    /**
     * @param int $id
     *
     * @return Maze
     */
    public function findOneById($id)
    {
        return $this->getManager()->getRepository('ApiBundle:Maze')->find($id);
    }

}
