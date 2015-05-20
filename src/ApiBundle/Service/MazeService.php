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
                    $mazePointIsObstacle = $randomNumber > $maze->getBrickDensity();
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

    }
}
