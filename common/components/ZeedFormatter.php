<?php 

namespace common\components;

use Yii;

/**
 * Extends Formatter functionality to get local datetime
 * Also for custom decimal format for Crypto Currency
 */
class ZeedFormatter extends \yii\i18n\Formatter
{
    /**
     * Get time in hh:mm z format ('09:47 WITA' or '08:47 WIB')
     * @param  string $value  should be value from PostgreSQL 'timestamp with timezone' field
     * @return string
     */
    public function asShorttime($value)
    {
        $timestamp = strtotime($value);
        $fmt = new \IntlDateFormatter(Yii::$app->formatter->locale, \IntlDateFormatter::NONE, \IntlDateFormatter::LONG);

        $fmt->setPattern('hh:mm z');

        return $fmt->format($timestamp);
    }

    /**
     * Convert any date() to compatible Psql-timestamp-with-timezone
     * @param  string $value  date, with Y-m-d format will do 
     * @param  string $format desired format 
     * @return string timestamp with timezone format (Y-m-d H:i:s.uO)
     */
    public function asPsqlTimestamp($value, $format = 'Y-m-d H:i:s.uO')
    {
        $timestamp = strtotime($value);

        $psql_timestamp = date($format, $timestamp);

        return $psql_timestamp;
    }

    /**
     * Replace asDate() formatter function to our "local" date. Because, 
     * asDate() IGNORES the timezone if we input the date format. 
     *
     * For example: It's 23:00:01 at Jakarta, but if we convert
     * it using the mall's timezone (Asia/Makassar), 
     * it will be 01:00:01 the next day. Thus, asDate() will give us
     * the wrong date(!)
     *
     * @param string $value datetime
     * @param string $format desired format
     * @return string
     */
    public function asLocalDate($value = 'NOW', $format = 'php:Y-m-d')
    {
        return $this->asDatetime($value, $format);
    }

    /**
     * Format float value with `.` as decimal separator without thousands separator,
     * instead of display with scientific float value. This also trailing zeros and
     * decimal separator if necessary.
     *
     * When decimal length of `$value` exceed from `$maxDecimal`, value of `$value`
     * will round as {@link number_format()} do.
     *
     * Example:
     * ```
     *  Yii::$app->formatter->asDynamicDecimal(1.0E-8); // Will Print `0.00000001`
     *  Yii::$app->formatter->asDynamicDecimal(10.100); // Will Print `10.1`
     *  Yii::$app->formatter->asDynamicDecimal(100.000); // Will Print `100`
     *  Yii::$app->formatter->asDynamicDecimal(0.0006, 3); // Will Print `0.001`
     * ```
     *
     * Ussually used this for displaying cryptocurrency value.
     *
     * @param float $value
     * @param int $maxDecimal
     * @return string
     */
    public function asDynamicDecimal($value, $maxDecimal = 8)
    {
        $value = number_format($value, $maxDecimal, '.', '');
        return preg_replace('/\.?0+$/', '', $value);
    }
}