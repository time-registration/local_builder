<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-29
 */
namespace Net\Bazzline\TimeRegistration\LocalBuilder\Utility;

class Time
{
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
}