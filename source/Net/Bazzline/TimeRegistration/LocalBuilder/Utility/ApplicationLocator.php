<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2015-11-29
 */

namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

use Net\Bazzline\Component\Locator\FactoryInterface;
use Net\Bazzline\Component\Locator\LocatorInterface;

/**
 * Class ApplicationLocator
 *
 * @package Net\Bazzline\TimeRegistration\LocalBuilder\Utility
 */
class ApplicationLocator implements LocatorInterface
{
    /**
     * @var $factoryInstancePool
     */
    private $factoryInstancePool = [];

    /**
     * @var $sharedInstancePool
     */
    private $sharedInstancePool = [];

    /**
     * @return \Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CollectionOfEntries
     */
    public function getCollectionOfEntries()
    {
        return $this->fetchFromFactoryInstancePool('\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CollectionOfEntriesFactory')->create();
    }

    /**
     * @return \Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration
     */
    public function getConfiguration()
    {
        $className = '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration';

        if ($this->isNotInSharedInstancePool($className)) {
            $factoryClassName = '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\ConfigurationFactory';
            $factory = $this->fetchFromFactoryInstancePool($factoryClassName);
            
            $this->addToSharedInstancePool($className, $factory->create());
        }

        return $this->fetchFromSharedInstancePool($className);
    }

    /**
     * @return \Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Filesystem
     */
    public function getFilesystem()
    {
        return $this->fetchFromSharedInstancePool('\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Filesystem');
    }

    /**
     * @return \Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CharacterString
     */
    public function getCharacterString()
    {
        return $this->fetchFromSharedInstancePool('\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CharacterString');
    }

    /**
     * @return \Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Time
     */
    public function getTime()
    {
        return $this->fetchFromSharedInstancePool('\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Time');
    }

    /**
     * @param string $className
     * @return FactoryInterface
     * @throws InvalidArgumentException
     */
    final protected function fetchFromFactoryInstancePool($className)
    {
        if ($this->isNotInFactoryInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'factory class "' . $className . '" does not exist'
                );
            }
            
            /** @var FactoryInterface $factory */
            $factory = new $className();
            $factory->setLocator($this);
            $this->addToFactoryInstancePool($className, $factory);
        }

        return $this->getFromFactoryInstancePool($className);
    }

    /**
     * @param string $className
     * @param FactoryInterface $factory
     * @return $this
     */
    private function addToFactoryInstancePool($className, FactoryInterface $factory)
    {
        $this->factoryInstancePool[$className] = $factory;

        return $this;
    }

    /**
     * @param string $className
     * @return null|FactoryInterface
     */
    private function getFromFactoryInstancePool($className)
    {
        return $this->factoryInstancePool[$className];
    }

    /**
     * @param string $className
     * @return boolean
     */
    private function isNotInFactoryInstancePool($className)
    {
        return (!isset($this->factoryInstancePool[$className]));
    }

    /**
     * @param string $className
     * @return object
     * @throws InvalidArgumentException
     */
    final protected function fetchFromSharedInstancePool($className)
    {
        if ($this->isNotInSharedInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'class "' . $className . '" does not exist'
                );
            }
            
            $instance = new $className();
            $this->addToSharedInstancePool($className, $instance);
        }

        return $this->getFromSharedInstancePool($className);
    }

    /**
     * @param string $className
     * @param object $instance
     * @return $this
     */
    private function addToSharedInstancePool($className, $instance)
    {
        $this->sharedInstancePool[$className] = $instance;

        return $this;
    }

    /**
     * @param string $className
     * @return null|object
     */
    private function getFromSharedInstancePool($className)
    {
        return $this->sharedInstancePool[$className];
    }

    /**
     * @param string $className
     * @return boolean
     */
    private function isNotInSharedInstancePool($className)
    {
        return (!isset($this->sharedInstancePool[$className]));
    }
}
