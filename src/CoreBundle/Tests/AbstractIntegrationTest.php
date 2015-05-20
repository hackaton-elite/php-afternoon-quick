<?php


namespace CoreBundle\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

/**
 * Governs all of the integration test classes.
 *
 * @package CoreBundle\Tests\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
abstract class AbstractIntegrationTest extends WebTestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->container = static::$kernel->getContainer();
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
