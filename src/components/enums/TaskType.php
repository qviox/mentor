<?php

namespace qviox\mentor\components\enums;


/**
 * Class TaskType
 * @package app\components\enums
 */
class TaskType
{
    public const COMMAND        = 'command';
    public const INDIVIDUAL     = 'individual';

    /**
     * @return array
     */
    public static function values()
    {
        return [
            self::INDIVIDUAL,
            self::COMMAND
        ];
    }

    /**
     * @return array
     */
    public static function map()
    {
        return [
            self::INDIVIDUAL    => 'Индивидуальное',
            self::COMMAND       => 'Командное'
        ];
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public static function label($value)
    {
        $map = self::map();
        return array_key_exists($value, $map) ? $map[$value] : null;
    }
}