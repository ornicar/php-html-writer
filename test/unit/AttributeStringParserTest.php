<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriterAttributeStringParser.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   *  invalid expressions
   */
  array(
    'params'  =>  array(null),
    'throws'  =>  'InvalidArgumentException'
  ),
  array(
    'params'  =>  array(array()),
    'throws'  =>  'InvalidArgumentException'
  ),
  /**
   * empty attributes
   */
  array(
    'params'  =>  array(''),
    'result'  =>  array()
  ),
  /**
   * simple attributes
   */
  array(
    'params'  =>  array('rel="my_rel"'),
    'result'  =>  array('rel' => 'my_rel')
  ),
  array(
    'params'  =>  array('rel="my_rel" title="my title"'),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  array(
    'params'  =>  array('rel= title="my title"'),
    'result'  =>  array('rel' => '', 'title' => 'my title')
  ),
  array(
    'params'  =>  array('  rel="my_rel"   title="my title"  '),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  /**
   * simple attributes without quotes
   */
  array(
    'params'  =>  array('rel=my_rel'),
    'result'  =>  array('rel' => 'my_rel')
  ),
  array(
    'params'  =>  array('rel=my_rel title="my title"'),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  /**
   * attributes preceded with a css expression
   */
  array(
    'params'  =>  array('div rel="my_rel"'),
    'result'  =>  array('rel' => 'my_rel')
  ),
  array(
    'params'  =>  array('div#my_id rel="my_rel" title="my title"'),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  array(
    'params'  =>  array('div.my_class rel="my_rel" title="my title"'),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  array(
    'params'  =>  array('div#my_id.my_class.another_class rel="my_rel" title="my title"'),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  array(
    'params'  =>  array(' div#my_id.my_class.another_class  rel="my_rel" title="my title" '),
    'result'  =>  array('rel' => 'my_rel', 'title' => 'my title')
  ),
  /**
   * pure a css expression
   */
  array(
    'params'  =>  array('div.my_class'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array('div#my_id'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array('div#my_id.my_class.another_class'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array(' div#my_id.my_class.another_class '),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array('.my_class'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array('#my_id'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array('#my_id.my_class.another_class'),
    'result'  =>  array()
  ),
  array(
    'params'  =>  array(' #my_id.my_class.another_class '),
    'result'  =>  array()
  )
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriterAttributeStringParser(), 'parse'));