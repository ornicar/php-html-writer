<?php

/**
 * Responsible to parse user attribute arrays
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */

class phpHtmlWriterAttributeArrayParser
{

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
      return $attributes;
    }

    // support array of classes
    if(isset($attributes['class']) && is_array($attributes['class']))
    {
      $attributes['class'] = implode(' ', $attributes['class']);
    }

    foreach($attributes as $name => $value)
    {
      if('json' !== $name)
      {
        $attributes[$name] = trim($value);
      }
    }

    // support JSON
    if(array_key_exists('json', $attributes))
    {
      $attributes = $this->parseJsonAttribute($attributes);
    }

    return $attributes;
  }

  protected function parseJsonAttribute(array $attributes)
  {
    $json = json_encode($attributes['json']);
    
    $attributes['class'] = isset($attributes['class'])
    ? $attributes['class'].' '.$json
    : $json;

    unset($attributes['json']);

    return $attributes;
  }

}