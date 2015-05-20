<?php


namespace ApiBundle\Service;


use ApiBundle\Entity\Maze;

class MazeService extends AbstractEntityManagerService
{
    /**
     * @param Maze $maze
     *
     * @return Maze
     */
    public function generateNewMaze(Maze $maze)
    {
        /* Save current maze metadata. */
        $this->getManager()->persist($maze);
        $this->getManager()->flush();

        return $maze;
    }

    /**
     * @param Maze $maze
     *
     * @return array
     */
    public function getMazeAsArray(Maze $maze) {
        return [];
    }
}
