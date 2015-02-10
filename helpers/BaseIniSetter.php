<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac.gmail.com>
 */

namespace axy\envnorm\helpers;

/**
 * The basic implementation of IIniSetter
 */
abstract class BaseIniSetter implements IIniSetter
{
    /**
     * {@inheritdoc}
     */
    public function setErrorReporting($level)
    {
        $this->set('error_reporting', $level);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorReporting()
    {
        return $this->get('error_reporting');
    }

    /**
     * {@inheritdoc}
     */
    public function setTimezone($timezone)
    {
        $this->set('date.timezone', $timezone);
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        return $this->get('date.timezone');
    }

    /**
     * {@inheritdoc}
     */
    public function setEncoding($encoding)
    {
        $this->set('mbstring.internal_encoding', $encoding);
    }
}
