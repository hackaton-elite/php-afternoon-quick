<?php


namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Definition of the Maze object.
 *
 * @package ApiBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\Entity()
 * @ORM\Table(name="maze")
 * @ORM\HasLifecycleCallbacks()
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
     */
    protected $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    protected $height;

    /**
     * @var int
     *
     * @ORM\Column(name="brick_density", type="integer")
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
}
