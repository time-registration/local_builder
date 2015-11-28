<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Configuration;

class Configuration
{
    const CURRENT_VERSION           = 0;
    const FILE_NAME                 = 'local_builder.php';
    const RELATIVE_DIRECTORY_PATH   = '.time-registration/configuration';

    /** @var int */
    private $fixedCharacterNumberOfSubjectSection;

    /** @var string */
    private $pathToStoreTheData;

    /** @var string */
    private $prefixForCurrentDay;

    /**
     * @return int
     */
    public function getCurrentVersion()
    {
        return self::CURRENT_VERSION;
    }

    /**
     * @return int
     */
    public function getFixedCharacterNumberOfSubjectSection()
    {
        return $this->fixedCharacterNumberOfSubjectSection;
    }

    /**
     * @param int $fixedCharacterNumberOfSubjectSection
     */
    public function setFixedCharacterNumberOfSubjectSection($fixedCharacterNumberOfSubjectSection)
    {
        $this->fixedCharacterNumberOfSubjectSection = $fixedCharacterNumberOfSubjectSection;
    }

    /**
     * @return string
     */
    public function getPathToStoreTheData()
    {
        return $this->pathToStoreTheData;
    }

    /**
     * @param string $pathToStoreTheData
     */
    public function setPathToStoreTheData($pathToStoreTheData)
    {
        $this->pathToStoreTheData = $pathToStoreTheData;
    }

    /**
     * @return string
     */
    public function getPrefixForCurrentDay()
    {
        return $this->prefixForCurrentDay;
    }

    /**
     * @param string $prefixForCurrentDay
     */
    public function setPrefixForCurrentDay($prefixForCurrentDay)
    {
        $this->prefixForCurrentDay = $prefixForCurrentDay;
    }
}