<?php


namespace ApiBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;

/**
 * Governs services that offer entity interaction functionality.
 *
 * @package ApiBundle\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
abstract class AbstractEntityManagerService
{

    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->manager = $objectManager;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @return $this
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }


}
