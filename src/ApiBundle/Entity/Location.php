<?php


namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Defines a location point. Used for start and end points.
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class Location extends AbstractTemporalEntity
{
    /**
     * @var Maze
     *
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\Maze")
     */
    protected $maze;

    /**
     * @var int
     *
     * @ORM\Column(name="x", type="integer")
     */
    protected $xCoordinate;

    /**
     * @var int
     *
     * @ORM\Column(name="y", type="integer")
     */
    protected $yCoordinate;

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
     * @return int
     */
    public function getXCoordinate()
    {
        return $this->xCoordinate;
    }

    /**
     * @param int $xCoordinate
     *
     * @return $this
     */
    public function setXCoordinate($xCoordinate)
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    /**
     * @return int
     */
    public function getYCoordinate()
    {
        return $this->yCoordinate;
    }

    /**
     * @param int $yCoordinate
     *
     * @return $this
     */
    public function setYCoordinate($yCoordinate)
    {
        $this->yCoordinate = $yCoordinate;

        return $this;
    }


}
