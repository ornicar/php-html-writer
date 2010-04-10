<?php

/**
 * an HTML element composed with a tag, html attributes and some content
 * can be rendered using __toString() or by simple string concatenation:
 * 'some text'.$element
 */
class phpHtmlWriterElement
{
  /**
   * the HTML Tag (like "div" or "a")
   * @var string
   */
  protected $tag;

  /**
   * the HTML attributes
   * @var string 
   */
  protected $attributes;

  /**
   * the tag content
   * @var mixed
   */
  protected $content;

  /**
   * the character encoding
   * @var string
   */
  protected $encoding;

  /**
   * from the W3 Schools reference site: http://www.w3schools.com/tags/ref_byfunc.asp
   * @var array
   */
  protected static $selfClosingTags = array('area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta');

  public function __construct($tag, array $attributes = array(), $content = '', $encoding = 'UTF-8')
  {
    $this->tag        = $tag;
    $this->attributes = $attributes;
    $this->content    = (string) $content;
    $this->encoding   = $encoding;

    if(empty($this->tag))
    {
      throw new InvalidArgumentException('You must provide an HTML tag');
    }

    if($this->isSelfClosing() && !empty($this->content))
    {
      throw new InvalidArgumentException($this->tag.' is a self-closing element, and does not support content');
    }
  }

  /**
   * Render the element
   * @return  string  valid XHTML representation of the element
   */
  public function render()
  {
    $tag        = $this->getTag();
    $attributes = $this->getAttributesAsString();

    if($this->isSelfClosing())
    {
      $html = '<'.$tag.$attributes.' />';
    }
    else
    {
      $html = '<'.$tag.$attributes.'>'.$this->getContent().'</'.$tag.'>';
    }

    return $html;
  }

  /**
   * Open the element
   * @return  string  valid XHTML representation of the open tag of the element
   */
  public function renderOpen()
  {
    if($this->isSelfClosing())
    {
      throw new LogicException($this->tag.' is a self-closing tag and not be opened - use->tag() instead');
    }
    
    return '<'.$this->getTag().$this->getAttributesAsString().'>';
  }

  /**
   * Close the element
   * @return  string  valid XHTML representation of the close tag of the element
   */
  public function renderClose()
  {
    if($this->isSelfClosing())
    {
      throw new LogicException($this->tag.' is a self-closing tag and not be closed - use->tag() instead');
    }

    return '</'.$this->getTag().'>';
  }

  /**
   * Tell if the tag if self-closing
   * @return  bool  return true if the tag is self-closing, false otherwise
   */
  public function isSelfClosing()
  {
    return in_array($this->getTag(), self::$selfClosingTags);
  }

  /**
   * Get the element tag name
   * @return  string  HTML tag name
   */
  public function getTag()
  {
    return $this->tag;
  }

  /**
   * Get the element tag attributes
   * @return  array  HTML tag attributes
   */
  public function getAttributes()
  {
    return $this->attributes;
  }

  /**
   * Get the element content
   * @return  string  HTML tag content
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Get the character encoding
   * @return  string  the current character encoding
   */
  public function getEncoding()
  {
    return $this->encoding;
  }

  /**
   * Set the character encoding
   * @param  string  $encoding  the new character encoding
   */
  public function setEncoding($encoding)
  {
    $this->encoding = $encoding;
  }

  /**
   * Get a HTML valid string containing the element attributes
   * @return  string  HTML representation of the element attributes
   */
  public function getAttributesAsString()
  {
    // convert options array to string
    $string = '';

    foreach($this->getAttributes() as $name => $value)
    {
      $escapedValue = htmlentities($value, ENT_COMPAT, $this->encoding);
      
      $string .= ' '.$name.'="'.$escapedValue.'"';
    }

    return $string;
  }

  public function __toString()
  {
    return $this->render();
  }
}