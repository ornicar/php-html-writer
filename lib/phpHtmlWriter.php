<?php

/**
 * Simple PHP HTML Writer
 *
 * @tutorial  http://github.com/ornicar/php-html-writer/blob/master/README.markdown
 * @version   0
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 *
 * Website: http://github.com/ornicar/php-html-writer
 * Tickets: http://github.com/ornicar/php-html-writer/issues
 */

require_once(dirname(__FILE__).'/phpHtmlWriterConfigurable.php');

class phpHtmlWriter extends phpHtmlWriterConfigurable
{
  /**
   * @var phpHtmlWriterCssParser  the CSS expression parser instance
   */
  protected $cssExpressionParser;
  
  /**
   * @var array                   the writer options
   */
  protected $options = array(
    'encoding'               => 'UTF-8',
    // from the W3 Schools reference site: http://www.w3schools.com/tags/ref_byfunc.asp
    'self_closing_elements'  => array('area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta')
  );

  /**
   * Instanciate a new HTML Writer
   */
  public function __construct(array $options = array())
  {
    $this->configure($options);
  }

  /**
   * Render a HTML tag
   *
   * Examples:
   * $view->tag('p', 'text content')
   * $view->tag('div#my_id.my_class', 'text content')
   * $view->tag('div', $view->tag('p', 'textual content'))
   * $view->tag('a', array('title' => 'my title'), 'text content')
   *
   * @param string  $cssExpression      a valid CSS expression like "div.my_class"
   * @param mixed   $attributes         additional HTML attributes, or tag content
   * @param string  $content            tag content if attributes are provided
   */
  public function tag($cssExpression, $attributes = array(), $content = null)
  {
    // use $attributes as $content if needed
    if(empty($content) && !empty($attributes) && !is_array($attributes))
    {
      $content    = $attributes;
      $attributes = array();
    }
    
    $attributes = $this->mergeAttributes(
      $this->getCssExpressionParser()->parse($cssExpression),
      $this->cleanUserAttributes($attributes)
    );

    $tag = $this->doRenderTag($attributes, $content);

    return $tag;
  }

  protected function doRenderTag(array $attributes, $content)
  {
    if (empty($attributes['tag']))
    {
      throw new InvalidArgumentException('You must provide a tag name');
    }
    
    // extract tag name from attributes
    $tagName = $attributes['tag'];

    // convert attributes array to string
    $htmlAttributes = $this->toHtmlAttributes($attributes);

    // render self-closing element
    if(in_array($tagName, $this->options['self_closing_elements']))
    {
      if(!empty($content))
      {
        throw new InvalidArgumentException($tagName.' is a self-closing element, and does not support content');
      }

      $tag = '<'.$tagName.$htmlAttributes.' />';
    }
    else
    {
      $tag = '<'.$tagName.$htmlAttributes.'>'.$content.'</'.$tagName.'>';
    }

    return $tag;
  }

  protected function mergeAttributes(array $attributes1, array $attributes2)
  {
    // manually merge classes array
    if(!empty($attributes2['classes']) && isset($attributes1['classes']))
    {
      $attributes2['classes'] = array_merge($attributes1['classes'], $attributes2['classes']);
      
      unset($attributes1['classes']);
    }

    return array_merge($attributes1, $attributes2);
  }

  protected function cleanUserAttributes($attributes)
  {
    if(empty($attributes))
    {
      return array();
    }

    if(!is_array($attributes))
    {
      throw new InvalidArgumentException('$attributes must be an array, '.gettype($ttributes).' given');
    }

    // merge class string to classes array
    if(isset($attributes['class']))
    {
      $attributes['classes'] = array_merge(
        isset($attributes['classes']) ? $attributes['classes'] : array(),
        explode(' ', $attributes['class'])
      );
      
      unset($attributes['class']);
    }

    foreach($attributes as $name => $value)
    {
      if('classes' !== $name)
      {
        $attributes[$name] = trim((string) $value);
      }
    }

    return $attributes;
  }

  /**
   * Get the CSS expression parser instance
   *
   * @return  phpHtmlWriterCssExpressionParser  the CSS expression parser
   */
  public function getCssExpressionParser()
  {
    if(null === $this->cssExpressionParser)
    {
      require_once(dirname(__FILE__).'/phpHtmlWriterCssExpressionParser.php');
      $this->cssExpressionParser = new phpHtmlWriterCssExpressionParser();
    }
    
    return $this->cssExpressionParser;
  }

  protected function toHtmlAttributes(array $attributes)
  {
    unset($attributes['tag']);
    
    // convert classes array to string
    if (isset($attributes['classes']))
    {
      $attributes['class'] = implode(' ', array_unique(array_filter(array_map('trim', $attributes['classes']))));
      unset($attributes['classes']);
    }

    // convert attributes array to string
    $htmlAttributes = '';
    foreach ($attributes as $name => $val)
    {
      $htmlAttributes .= ' '.$name.'="'.htmlentities($val, ENT_COMPAT, $this->options['encoding']).'"';
    }

    return $htmlAttributes;
  }
}