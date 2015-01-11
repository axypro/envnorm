<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac.gmail.com>
 */

namespace axy\envnorm\helpers;

/**
 * The implementation of IIniSetter for testing
 */
class TestIniSetter extends BaseIniSetter
{
    /**
     * The constructor
     *
     * @param array $options [optional]
     *        initial options values
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }

    /**
     * @var array
     */
    private $options;
}
