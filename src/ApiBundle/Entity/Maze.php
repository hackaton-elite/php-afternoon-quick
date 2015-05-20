<?php


namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Definition of the Maze object.
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\Entity()
 * @ORM\Table(name="maze")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Maze extends AbstractTemporalEntity
{
    public function __construct()
    {
        $this->mazePoints = new ArrayCollection();
    }

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\MazePoint", mappedBy="maze")
     */
    protected $mazePoints;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("width")
     * @JMS\Expose()
     */
    protected $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("height")
     * @JMS\Expose()
     */
    protected $height;

    /**
     * @var int
     *
     * @ORM\Column(name="brick_density", type="integer")
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("brick_density")
     * @JMS\Expose()
     */
    protected $brickDensity;

    /**
     * @var StartLocation
     *
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\StartLocation", mappedBy="maze")
     */
    protected $startLocation;

    /**
     * @var EndLocation
     *
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\EndLocation", mappedBy="maze")
     */
    protected $endLocation;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getBrickDensity()
    {
        return $this->brickDensity;
    }

    /**
     * @param int $brickDensity
     *
     * @return $this
     */
    public function setBrickDensity($brickDensity)
    {
        $this->brickDensity = $brickDensity;

        return $this;
    }

    /**
     * @return StartLocation
     */
    public function getStartLocation()
    {
        return $this->startLocation;
    }

    /**
     * @param StartLocation $startLocation
     *
     * @return $this
     */
    public function setStartLocation($startLocation)
    {
        $this->startLocation = $startLocation;

        return $this;
    }

    /**
     * @return EndLocation
     */
    public function getEndLocation()
    {
        return $this->endLocation;
    }

    /**
     * @param EndLocation $endLocation
     *
     * @return $this
     */
    public function setEndLocation($endLocation)
    {
        $this->endLocation = $endLocation;

        return $this;
    }

    public function addMazePoint(MazePoint $mazePoint)
    {
        $this->mazePoints->add($mazePoint);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMazePoints()
    {
        return $this->mazePoints;
    }

    /**
     * @param ArrayCollection $mazePoints
     *
     * @return $this
     */
    public function setMazePoints($mazePoints)
    {
        $this->mazePoints = $mazePoints;

        return $this;
    }


}
