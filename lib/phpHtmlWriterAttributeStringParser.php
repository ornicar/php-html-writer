<?php

/**
 * Responsible to parse user inline attributes
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */

require_once(dirname(__FILE__).'/phpHtmlWriterConfigurable.php');

class phpHtmlWriterAttributeStringParser extends phpHtmlWriterConfigurable
{
  /**
   * @var array                   the parser options
   */
  protected $options = array(
    // used by htmlentities
    'encoding'                => 'UTF-8'
  );

  /**
   * Entry point of the class, parse an attribute array
   *
   * @param   array    $attributes    the attribute array
   * @return  array                   the parsed attributes
   */
  public function parse($expression)
  {
    if(!is_string($expression))
    {
      throw new InvalidArgumentException('The inline attributes must be a string, '.gettype($expression).' given');
    }
    
    if(empty($expression) || false === strpos($expression, '='))
    {
      return array();
    }

    return $this->stringToArray($expression);
  }
  
  /**
   * Copied from symfony 1.4 http://symfony-project.org/
   * Converts string to array
   *
   * @param  string $string  the value to convert to array
   *
   * @return array
   */
  protected function stringToArray($string)
  {
    preg_match_all('/
      \s*(\w+)              # key                               \\1
      \s*=\s*               # =
      (\'|")?               # values may be included in \' or " \\2
      (.*?)                 # value                             \\3
      (?(2) \\2)            # matching \' or " if needed        \\4
      \s*(?:
        (?=\w+\s*=) | \s*$  # followed by another key= or the end of the string
      )
    /x', $string, $matches, PREG_SET_ORDER);

    $attributes = array();
    foreach ($matches as $val)
    {
      $attributes[$val[1]] = $this->literalize($val[3]);
    }

    return $attributes;
  }

  /**
   * Copied from symfony 1.4 http://symfony-project.org/
   * With some modifications
   * Finds the type of the passed value, returns the value as the new type.
   *
   * @param  string $value
   *
   * @return mixed
   */
  protected function literalize($value)
  {
    if (empty($value))
    {
      $value = null;
    }
    elseif (in_array($value, array('true', 'on', '+', 'yes')))
    {
      $value = true;
    }
    elseif (in_array($value, array('false', 'off', '-', 'no')))
    {
      $value = false;
    }

    return $value;
  }

}