<?php


namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Defines a location point. Used for start and end points.
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 *
 * @JMS\ExclusionPolicy("all")
 */
class Location extends AbstractTemporalEntity
{
    public function __construct($xCoordinate = 0, $yCoordinate = 0)
    {
        $this
            ->setXCoordinate($xCoordinate)
            ->setYCoordinate($yCoordinate);
    }

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
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("xCoordinate")
     * @JMS\Expose()
     */
    protected $xCoordinate;

    /**
     * @var int
     *
     * @ORM\Column(name="y", type="integer")
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("yCoordinate")
     * @JMS\Expose()
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
