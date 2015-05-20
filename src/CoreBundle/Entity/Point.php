<?php


namespace CoreBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Point
 *
 * @package CoreBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @JMS\ExclusionPolicy("all")
 */
class Point
{
    public function __construct($xCoordinate, $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    function __toString()
    {
        return "[{$this->getXCoordinate()}, {$this->getYCoordinate()}]";
    }

    /**
     * @var int
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("xCoordinate")
     * @JMS\Expose()
     */
    protected $xCoordinate;

    /**
     * @var int
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("yCoordinate")
     * @JMS\Expose()
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


}
