<?php

/**
 * Responsible to parse CSS expressions like "div#my_id.my_class"
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpHtmlWriterCssExpressionParser
{

  /**
   * Entry point of the class, parse a CSS expression
   *
   * @param   string    $string       the CSS expression like "div#my_id.my_class"
   * @return  array                   the parsed attributes
   */
  public function parse($expression)
  {
    $expression = $this->cleanExpression($expression);
    
    $data       = array();

    $this->fetchTag($expression, $data);

    $this->fetchId($expression, $data);

    $this->fetchClasses($expression, $data);

    return $data;
  }

  protected function cleanExpression($expression)
  {
    if(!is_string($expression))
    {
      throw new InvalidArgumentException('The CSS expression must be a string, '.gettype($expression).' given');
    }
    
    $originalExpression = $expression;
    
    $expression = preg_replace('/^([\w|-|\#|\.]+)/i', '$1', trim($originalExpression));

    if (empty($expression))
    {
      throw new InvalidArgumentException('The CSS expression "'.$originalExpression.'" is not valid');
    }

    return $expression;
  }

  protected function fetchTag($expression, &$data)
  {
    if('#' !== $expression{0} && '.' !== $expression{0})
    {
      preg_match('/^([^\#|\.]+)/', $expression, $result);

      if (isset($result[1]))
      {
        $data['tag'] = $result[1];
      }
    }
  }

  protected function fetchId($expression, &$data)
  {
    // if we have a "#"
    if (false !== strpos($expression, '#'))
    {
      // fetch id
      preg_match('/#([\w\-]*)/', $expression, $result);

      if (isset($result[1]))
      {
        $data['id'] = $result[1];
      }
    }
  }

  protected function fetchClasses($expression, &$data)
  {
    // if we have at least one "."
    if(false !== strpos($expression, '.'))
    {
      preg_match_all('/\.([\w\-]+)/', $expression, $result);

      $data['classes'] = $result[1];
    }
  }

}