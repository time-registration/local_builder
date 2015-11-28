<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

use Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration;
use RuntimeException;

class CollectionOfEntries
{
    /** @var string */
    private $content;

    /** @var Configuration */
    private $configuration;

    /** @var Filesystem */
    private $filesystem;

    /** @var bool */
    private $isModified;

    /** @var string */
    private $name;

    /** @var string */
    private $path;

    /**
     * @param Configuration $configuration
     */
    public function injectConfiguration(Configuration $configuration)
    {
        $this->configuration    = $configuration;
        $this->path             = $configuration->getPathToStoreTheData();
        $this->loadContentIfPossible();
    }

    /**
     * @param Filesystem $filesystem
     */
    public function injectFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name . '.md';
        $this->loadContentIfPossible();
    }

    /**
     * @param string $line
     */
    public function addLine($line)
    {
        $this->addLineToContent($line);
    }

    /**
     * @param string $description
     * @param string $subject
     * @param int $timestamp
     */
    public function addEntry($description, $subject, $timestamp)
    {
        $configuration  = $this->configuration;
        $currentDate    = $this->generateCurrentDate($timestamp);
        $path           = $configuration->getPathToStoreTheData();
        $filesystem     = $this->filesystem;
        $filePath       = $this->getFilePath();
        $timeAsString   = $this->generateTimeAsString($timestamp);

        $timeAsString      .= str_repeat(' ', 3);    //make the string eight characters long
        $subjectAsString    = $subject . str_repeat(
            ' ',
            ($configuration->getFixedCharacterNumberOfSubjectSection() - strlen($subject))
        );
        //@todo

        $line = $timeAsString . $subjectAsString . trim($description) . PHP_EOL;

        //begin of add current date as header to the file
        $isTheFirstEntryFromTheCurrentDay = true;

        if ($filesystem->isFileAvailable($filePath)) {
            $isTheFirstEntryFromTheCurrentDay = (!$filesystem->fileContainsLine($filePath, $currentDate));
        } else {
            if (!$filesystem->isDirectoryAvailable($path)) {
                $filesystem->createDirectoryOrThrowRuntimeException($path);
            }
        }

        if ($isTheFirstEntryFromTheCurrentDay) {
            $line = $currentDate . PHP_EOL . PHP_EOL . $line;
        } else {
            $lineNumberFromCurrentDate = $filesystem->getLineNumberOfLineInFile($filePath, $currentDate);
            if ($lineNumberFromCurrentDate !== false) {
                if ($filesystem->fileContainsLine($filePath, '^' . $timeAsString, $lineNumberFromCurrentDate)) {
                    throw new RuntimeException(
                        'entry for current time (' .
                        trim($timeAsString) .
                        ') in current date (' .
                        $currentDate .
                        ') and current collection (' .
                        basename($filePath) .
                        ') already exist'
                    );
                }
            }
        }
        //end of add current date as header to the file

        $this->addLineToContent($line);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     * @todo implement validation and throw exception
     */
    public function getFilePath()
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->name;
    }

    /**
     * @throws RuntimeException
     */
    public function persist()
    {
        if ($this->isModified) {
            $content    = implode(PHP_EOL, $this->content) . PHP_EOL;
            $filesystem = $this->filesystem;
            $filePath   = $this->getFilePath();

            $filesystem->writeFileContentOrThrowRuntimeException(
                $filePath,
                $content,
                false
            );
        }
    }

    /**
     * @param string $line
     */
    private function addLineToContent($line)
    {
        $this->content[]    = trim($line);
        $this->isModified   = true;
    }

    /**
     * @param string $timestamp
     * @return string
     */
    private function generateCurrentDate($timestamp)
    {
        $configuration  = $this->configuration;
        $currentDate    = $configuration->getPrefixForCurrentDay() . date('ymd', $timestamp);

        return $currentDate;
    }

    /**
     * @param int $timestamp
     * @return string
     */
    private function generateTimeAsString($timestamp)
    {
        $currentHour    = date('H', $timestamp);
        $currentMinute  = date('i', $timestamp);

        if ($currentMinute <= 15) {
            $timeAsString = $currentHour . ':' . 15;
        } else if ($currentMinute <= 30) {
            $timeAsString = $currentHour . ':' . 30;
        } else if ($currentMinute <= 45) {
            $timeAsString = $currentHour . ':' . 45;
        } else {
            if ($currentHour < 9) {
                $timeAsString = '0' . ($currentHour + 1) . ':00';
            } else if ($currentHour < 23) {
                $timeAsString = ($currentHour + 1) . ':00';
            } else {
                $timeAsString = '00:00';
            }
        }

        return $timeAsString;
    }

    private function loadContentIfPossible()
    {
        $tryToLoadContent = ((!is_null($this->name))
            && (!is_null($this->path)));

        if ($tryToLoadContent) {
            $filesystem = $this->filesystem;
            $filePath   = $this->getFilePath();

            if ($filesystem->isFileAvailable($filePath)) {
                $contentAsString    = $this->filesystem->readFileContent($filePath);
                $content            = explode(PHP_EOL, $contentAsString);
                array_pop($content);    //removes empty last line
                $this->content      = $content;
                $this->isModified   = false;
            }
        }
    }
}