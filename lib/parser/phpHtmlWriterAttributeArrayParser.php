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

    $attributes = array_map('trim', $attributes);

    return $attributes;
  }

}