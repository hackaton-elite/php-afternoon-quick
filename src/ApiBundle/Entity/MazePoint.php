<?php


namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MazePoint
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\Entity()
 * @ORM\Table(name="maze_point")
 */
class MazePoint extends Location
{
    /**
     * @var Maze
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Maze")
     */
    protected $maze;

    /**
     * @var bool
     *
     * @ORM\Column(name="obstacle", type="boolean")
     */
    protected $obstacle;

    /**
     * @return Maze
     */
    public function getMaze()
    {
        return $this->maze;
    }

    /**
     * @param Maze $maze
     *
     * @return $this
     */
    public function setMaze($maze)
    {
        $this->maze = $maze;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isObstacle()
    {
        return $this->obstacle;
    }

    /**
     * @param boolean $obstacle
     *
     * @return $this
     */
    public function setObstacle($obstacle)
    {
        $this->obstacle = $obstacle;

        return $this;
    }
}
