<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-28
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

use RuntimeException;

class Filesystem
{
    /**
     * @param string $path
     * @param int $permission
     * @return bool
     */
    public function couldCreateDirectory($path, $permission = 0700)
    {
        return mkdir($path, $permission, true);
    }

    /**
     * @param string $path
     * @param mixed $content
     * @param bool|false $append
     * @return bool
     */
    public function couldWriteFileContent($path, $content, $append = true)
    {
        return (
            (
                $append
                    ? file_put_contents($path, $content, FILE_APPEND)
                    : file_put_contents($path, $content)
            ) !== false
        );
    }

    /**
     * @param string $path
     * @param int $permission
     * @throws RuntimeException
     */
    public function createDirectoryOrThrowRuntimeException($path, $permission = 0700)
    {
        $couldNotCreate = (!$this->couldCreateDirectory($path, $permission));

        if ($couldNotCreate) {
            throw new RuntimeException(
                'could not create path "' . $path . '"'
            );
        }
    }

    /**
     * @return string
     */
    public function getPathToCurrentUserHome()
    {
        return trim(shell_exec('echo $HOME'));
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isDirectoryAvailable($path)
    {
        return (is_dir($path));
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isFileAvailable($path)
    {
        return (is_file($path));
    }

    /**
     * @param string $path
     * @param mixed $content
     * @param bool|true $append
     * @throws RuntimeException
     */
    public function writeFileContentOrThrowRuntimeException($path, $content, $append = true)
    {
        $couldNotWrite = (!$this->couldWriteFileContent($path, $content, $append));

        if ($couldNotWrite) {
            throw new RuntimeException(
                'could not write into file path "' . $path . '"'
            );
        }
    }
}