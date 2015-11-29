<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

use InvalidArgumentException;
use Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration;
use RuntimeException;

class CollectionOfEntries
{
    /** @var array */
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

    /** @var Time */
    private $time;

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
     * @param Time $time
     */
    public function injectTime(Time $time)
    {
        $this->time = $time;
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
     * @param string $description
     * @param string $subject
     * @param int $timestamp
     * @throws InvalidArgumentException
     */
    public function addEntry($description, $subject, $timestamp)
    {
        $configuration  = $this->configuration;
        $currentDate    = $this->generateCurrentDate($timestamp);
        $path           = $configuration->getPathToStoreTheData();
        $filesystem     = $this->filesystem;
        $filePath       = $this->getFilePath();
        $time           = $this->time;
        $timeAsString   = $time->createHourAndMinutesForAnEntry($timestamp);

        //begin of argument validation
        $subjectIsToLong    = (strlen($subject) > $configuration->getFixedCharacterNumberOfSubjectSection());

        if ($subjectIsToLong) {
            throw new InvalidArgumentException(
                'provided subject is to long, maximum character length is ' .
                    $configuration->getFixedCharacterNumberOfSubjectSection()
            );
        }
        //end of argument validation

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
     * @param string $line
     */
    public function addComment($line)
    {
        $this->addLineToContent('#' . $line);
    }

    /**
     * @param int $timestamp
     * @return array
     */
    public function getEntries($timestamp)
    {
        $currentDate            = $this->generateCurrentDate($timestamp);
        $entries                = array();
        $lineNumberToStartWith  = false;

        foreach ($this->content as $lineNumber => $line) {
            if ($line === $currentDate) {
                $lineNumberToStartWith = $lineNumber;
                break;
            }
        }

        if ($lineNumberToStartWith !== false) {
            foreach ($this->content as $lineNumber => $line) {
                if ($lineNumber > $lineNumberToStartWith) {
                    $lineHasContent = (strlen($line) > 0);
                    $reachedNextDay = (($lineHasContent)
                        && ($line{0} === '_'));

                    if ($reachedNextDay) {
                        break;
                    }

                    if ($lineHasContent) {
                        $entries[] = $line;
                    }
                }
            }
        }

        return $entries;
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
            } else {
                $this->content      = array();
                $this->isModified   = false;
            }
        }
    }
}