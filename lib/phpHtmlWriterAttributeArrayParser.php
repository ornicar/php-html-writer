<?php

/**
 * Responsible to parse user attribute arrays
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */

require_once(dirname(__FILE__).'/phpHtmlWriterConfigurable.php');

class phpHtmlWriterAttributeArrayParser extends phpHtmlWriterConfigurable
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
  public function parse(array $attributes)
  {
    if(empty($attributes))
    {
      return array();
    }

    if(!is_array($attributes))
    {
      throw new InvalidArgumentException('$attributes must be an array, '.gettype($attributes).' given');
    }

    foreach($attributes as $name => $value)
    {
      $attributes[$name] = $this->processAttribute($name, $value);
    }

    return $attributes;
  }

  protected function processAttribute($name, $value)
  {
    return htmlentities(trim((string) $value), ENT_COMPAT, $this->options['encoding']);
  }

}