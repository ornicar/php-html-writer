<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriterCssExpressionParser.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   *  empty elements
   */
  array(                                  // one test
    'params'  =>  array('div'),           // ->parse() parameters
    'result'  =>  array('tag' => 'div')   // expected result
  ),
  array(
    'params'  =>  array(' input '),
    'result'  =>  array('tag' => 'input')
  ),
  /**
   *  invalid expressions
   */
  array(
    'params'  =>  array(null),
    'throws'  =>  'InvalidArgumentException'
  ),
  array(
    'params'  =>  array(' '),
    'throws'  =>  'InvalidArgumentException'
  ),
  array(
    'params'  =>  array(array()),
    'throws'  =>  'InvalidArgumentException'
  ),
  /**
   *  elements with id and classes
   */
  array(
    'params'  =>  array('p#my_id'),
    'result'  =>  array('tag' => 'p', 'id' => 'my_id')
  ),
  array(
    'params'  =>  array('p.my_class'),
    'result'  =>  array('tag' => 'p', 'class' => 'my_class')
  ),
  array(
    'params'  =>  array('p.my_class.another_class'),
    'result'  =>  array('tag' => 'p', 'class' => 'my_class another_class')
  ),
  array(
    'params'  =>  array('p#my_id.my_class.another_class'),
    'result'  =>  array('tag' => 'p', 'id' => 'my_id', 'class' => 'my_class another_class')
  ),
  array(
    'params'  =>  array(' p#my_id.my_class.another_class '),
    'result'  =>  array('tag' => 'p', 'id' => 'my_id', 'class' => 'my_class another_class')
  ),
  /**
   *  id and classes without element
   */
  array(
    'params'  =>  array('#my_id'),
    'result'  =>  array('id' => 'my_id')
  ),
  array(
    'params'  =>  array('.my_class'),
    'result'  =>  array('class' => 'my_class')
  ),
  array(
    'params'  =>  array('.my_class.another_class'),
    'result'  =>  array('class' => 'my_class another_class')
  ),
  array(
    'params'  =>  array('#my_id.my_class.another_class'),
    'result'  =>  array('id' => 'my_id', 'class' => 'my_class another_class')
  ),
  array(
    'params'  =>  array(' #my_id.my_class.another_class '),
    'result'  =>  array('id' => 'my_id', 'class' => 'my_class another_class')
  )
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriterCssExpressionParser(), 'parse'));