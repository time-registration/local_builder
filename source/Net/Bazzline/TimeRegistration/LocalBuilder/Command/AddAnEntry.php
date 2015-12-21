<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-12-22
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Command;

class AddAnEntry extends Abstractcommand
{
    public function addAnEntry($timestamp, $collection)
    {
        $timestamp              = $time->getTimestamp();
        $collection             = $locator->getCollectionOfEntries();
        $currentCalendarWeek    = $time->createCalendarWeek($timestamp);

        $collection->setName($currentCalendarWeek);
        $collection->setYear($time->createYear($timestamp));
        $collection->addEntry($description, '-', $timestamp);
        $collection->persist();

        $environment->outputIfVerbosityIsEnabled('added content to file:');
        $environment->outputIfVerbosityIsEnabled('to file:');
        $environment->outputIfVerbosityIsEnabled(basename($collection->getFilePath()));
    }
}