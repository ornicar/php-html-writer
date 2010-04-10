<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpHtmlWriter.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   *  pure elements with JSON
   */
  array(
    'params'  =>  array('div', array('json' => null)),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(null), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => 'json text')),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode('json text'), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => 'json " text')),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode('json " text'), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => array('json text'))),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(array('json text')), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => array('json " text'))),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(array('json " text')), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => array('json {} text'))),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(array('json {} text')), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => array(3, 4, 5))),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(array(3, 4, 5)), ENT_COMPAT, 'UTF-8'))
  ),
  array(
    'params'  =>  array('div', array('json' => array('3' => 'a', 'b' => 'c"c'))),
    'result'  =>  sprintf('<div class="%s">', htmlentities(json_encode(array('3' => 'a', 'b' => 'c"c')), ENT_COMPAT, 'UTF-8'))
  ),
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriter(), 'open'));