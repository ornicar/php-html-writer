<?php

/**
 * Here are some shortcut functions to phpHtmlWriter methods.
 * Include this file only if you want to use such non OO shortcuts.
 */

require_once(dirname(__FILE__).'/phpHtmlWriter.php');
$phpHtmlWriterInstance = new phpHtmlWriter();

/**
 * @see phpHtmlWriter::tag()
 */
function tag($cssExpression, $attributes = array(), $content = null)
{
  global $phpHtmlWriterInstance;
  return $phpHtmlWriterInstance->tag($cssExpression, $attributes, $content);
}