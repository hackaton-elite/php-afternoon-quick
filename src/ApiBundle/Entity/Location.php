<?php


namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Defines a location point. Used for start and end points.
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\Entity()
 * @ORM\Table(name="location")
 */
class Location extends AbstractTemporalEntity
{
    const START_POINT = 0;
    const END_POINT = 1;

    /**
     * @var Maze
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Maze")
     */
    protected $maze;

    /**
     * @var bool
     *
     * @ORM\Column(name="type", type="boolean")
     */
    protected $type;

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
    public function isType()
    {
        return $this->type;
    }

    /**
     * @param boolean $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
