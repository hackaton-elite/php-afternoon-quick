<?php


namespace ApiBundle\Entity;

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


}
