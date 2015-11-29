<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-29
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

class CharacterString
{
    /**
     * @param string $string
     * @param string $search
     * @return boolean
     */
    public function contains($string, $search)
    {
        if (strlen($search) == 0) {
            $contains = false;
        } else {
            $contains = !(strpos($string, $search) === false);
        }

        return $contains;
    }

    /**
     * @param string $string
     * @param array $searches
     * @return boolean
     */
    public function containsOneOf($string, array $searches)
    {
        $contains = false;

        foreach ($searches as $search) {
            if ($this->contains($string, $search)) {
                $contains = true;
                break;
            }
        }

        return $contains;
    }

    /**
     * @param string $string
     * @return int
     */
    public function filterNumbers($string)
    {
        return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    }
}