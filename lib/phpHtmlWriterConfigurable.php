<?php

/**
 * Provides basic methods for configurable services
 */
abstract class phpHtmlWriterConfigurable
{
  protected $options = array();

  /**
   * Configures the current object.
   *
   * @param array $options     An array of options
   */
  public function configure(array $options = array())
  {
    $this->options = array_merge($this->options, $options);
  }

  /**
   * Changes an option value.
   *
   * @param string $name   The option name
   * @param mixed  $value  The value
   */
  public function setOption($name, $value)
  {
    $this->options[$name] = $value;
  }

  /**
   * Gets an option value.
   *
   * @param  string $name The option name
   *
   * @return mixed  The option value
   */
  public function getOption($name, $default = null)
  {
    return isset($this->options[$name]) ? $this->options[$name] : $default;
  }
  
  /**
   * Gets all options.
   *
   * @return array  An array of named options
   */
  public function getOptions()
  {
    return $this->options;
  }

  /**
   * Sets the options.
   *
   * @param array $options  An array of options
   *
   * @return dmConfigurable The current object instance
   */
  public function setOptions(array $options)
  {
    $this->options = $options;

    return $this;
  }

}