<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

class CollectionOfEntriesFactory extends AbstractFactory
{
    public function create()
    {
        $collection     = new CollectionOfEntries();
        $locator        = $this->getLocator();
        $configuration  = $locator->getConfiguration();
        $filesystem     = $locator->getFilesystem();

        $collection->injectConfiguration($configuration);
        $collection->injectFilesystem($filesystem);

        return $collection;
    }
}