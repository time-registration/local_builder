<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-29
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

use DateTime;

class Time
{
    /** @var null|int */
    private $timestamp;

    /**
     * @param string $timestamp
     * @return int
     */
    public function createCalendarWeek($timestamp)
    {
        return (int) date('W', $timestamp);
    }

    /**
     * @param int $timestamp
     * @return bool|string
     */
    public function createDate($timestamp)
    {
        return date('Y-m-d', $timestamp);
    }

    /**
     * @param int $timestamp
     * @return DateTime
     */
    public function createDateTime($timestamp)
    {
        return new DateTime(date('Y-m-d H:i:s', $timestamp));
    }

    /**
     * @param int $timestamp
     * @return string
     */
    public function createHourAndMinutesForAnEntry($timestamp)
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

    /**
     * @param int $timestamp
     * @return int
     */
    public function createYear($timestamp)
    {
        return date('Y', $timestamp);
    }

    /**
     * @param int $seconds
     * @return string
     */
    public function formatSecondsIntoHourAndMinutes($seconds)
    {
        if ($seconds >= 3600) {
            $seconds -= 3600;   //@todo figure out why there is always one hour to much
            $currentHour = date('H', $seconds);
        } else {
            $currentHour = 0;
        }
        $currentMinute = date('i', $seconds);

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

    /**
     * @return int
     */
    public function getTimestamp()
    {
        if (is_null($this->timestamp)) {
            $this->timestamp = time();
        }

        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return int
     */
    public function roundDown($timestamp)
    {
        $hour               = date('H', $timestamp);
        $minutes            = date('i', $timestamp);
        $minutesAsSeconds   = $minutes * 60;
        $rounded            = ($minutes - ($minutes % 15));
        $roundedAsSeconds   = $rounded * 60;

        $roundedTimestamp   = $timestamp - $minutesAsSeconds + $roundedAsSeconds;

        return $roundedTimestamp;
    }
}
