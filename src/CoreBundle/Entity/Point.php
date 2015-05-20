<?php


namespace CoreBundle\Entity;


class Point
{
    public function __construct($xCoordinate, $yCoordinate, $brick = false)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
        $this->brick       = $brick;
    }

    /**
     * @var int
     */
    protected $xCoordinate;

    /**
     * @var int
     */
    protected $yCoordinate;

    /**
     * @var bool
     */
    protected $brick;

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
     * @return bool
     */
    public function isBrick()
    {
        return $this->brick;
    }

    /**
     * @param bool $brick
     *
     * @return $this
     */
    public function setBrick($brick)
    {
        $this->brick = $brick;

        return $this;
    }
}
