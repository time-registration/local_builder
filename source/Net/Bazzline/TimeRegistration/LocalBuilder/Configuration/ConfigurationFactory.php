<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Configuration;

use InvalidArgumentException;
use Net\Bazzline\Component\Locator\FactoryInterface;
use Net\Bazzline\Component\Locator\LocatorInterface;
use Net\Bazzline\TimeRegistration\LocalBuilder\Utility\ApplicationLocator;
use RuntimeException;

class ConfigurationFactory implements FactoryInterface
{
    /** @var LocatorInterface|ApplicationLocator */
    private $locator;

    public function setLocator(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function create()
    {
        $configuration  = new Configuration();
        $locator        = $this->locator;
        $filesystem     = $locator->getFilesystem();

        $pathToCurrentUserHome  = $filesystem->getPathToCurrentUserHome();
        $pathToConfiguration    = Configuration::RELATIVE_DIRECTORY_PATH;
        $configurationFileName  = Configuration::FILE_NAME;
        $fullQualifiedPath      = $pathToCurrentUserHome . '/' . $pathToConfiguration;
        $fullQualifiedFilePath  = $fullQualifiedPath . '/' . $configurationFileName;

        if ($filesystem->isFileAvailable($fullQualifiedFilePath)) {
            $array                              = require $fullQualifiedFilePath;
            $isSupportedConfigurationVersion    = ($configuration->getCurrentVersion() === $array['version']);

            if ($isSupportedConfigurationVersion) {
                $configuration->setFixedCharacterNumberOfSubjectSection($array['fixed_character_number_of_subject_section']);
                $configuration->setPathToStoreTheData($array['path_to_store_the_data']);
                $configuration->setPrefixForCurrentDay($array['prefix_for_current_day']);
            } else {
                throw new InvalidArgumentException(
                    'configuration version not supported'
                );
            }

        } else {
            throw new RuntimeException(
                'configuration file not available'
            );
        }

        return $configuration;
    }
}