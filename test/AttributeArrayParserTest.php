<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/parser/phpHtmlWriterAttributeArrayParser.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   * empty attributes
   */
  array(
    'params'  =>  array(array()),
    'result'  =>  array()
  ),
  /**
   * simple attributes
   */
  array(
    'params'  =>  array(array('rel' => 'my_rel')),
    'result'  =>  array('rel' => 'my_rel')
  ),
  array(
    'params'  =>  array(array('rel' => 'my_rel', 'title' => 'my title', 'class' => 'class1 class2')),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title', 'class' => 'class1 class2')
  ),
  /**
   * array classes
   */
  array(
    'params'  =>  array(array('rel' => 'my_rel', 'class' => array())),
    'result'  =>  array('rel' => 'my_rel', 'class' => '')
  ),
  array(
    'params'  =>  array(array('rel' => 'my_rel', 'class' => array('class1'))),
    'result'  =>  array('rel' => 'my_rel', 'class' => 'class1')
  ),
  array(
    'params'  =>  array(array('rel' => 'my_rel', 'class' => array('class1', 'class2'))),
    'result'  =>  array('rel' => 'my_rel', 'class' => 'class1 class2')
  ),
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriterAttributeArrayParser(), 'parse'));