<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/parser/phpHtmlWriterCssExpressionParser.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   *  invalid expressions
   */
  array(                                      // one test
    'params'  =>  array(null),                // ->parse() parameters
    'throws'  =>  'InvalidArgumentException'  // expected result
  ),
  array(
    'params'  =>  array(array()),
    'throws'  =>  'InvalidArgumentException'
  ),
  /**
   * empty expression
   */
  array(
    'params'  =>  array(' '),
    'result'  =>  array(null, array())
  ),
  /**
   *  empty elements
   */
  array(
    'params'  =>  array('div'),
    'result'  =>  array('div', array())
  ),
  array(
    'params'  =>  array(' input '),
    'result'  =>  array('input', array())
  ),
  /**
   *  elements with id and classes
   */
  array(
    'params'  =>  array('p#my_id'),
    'result'  =>  array('p', array('id' => 'my_id'))
  ),
  array(
    'params'  =>  array('p.my_class'),
    'result'  =>  array('p', array('class' => 'my_class'))
  ),
  array(
    'params'  =>  array('p.my_class.another_class'),
    'result'  =>  array('p', array('class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array('p#my_id.my_class.another_class'),
    'result'  =>  array('p', array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array(' p#my_id.my_class.another_class '),
    'result'  =>  array('p', array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),
  /**
   *  elements with id and classes and inline attributes
   */
  array(
    'params'  =>  array('p#my_id rel=my_rel title="my title"'),
    'result'  =>  array('p', array('id' => 'my_id'))
  ),
  array(
    'params'  =>  array('p.my_class rel=my_rel title="my title"'),
    'result'  =>  array('p', array('class' => 'my_class'))
  ),
  array(
    'params'  =>  array('p.my_class.another_class rel=my_rel title="my title"'),
    'result'  =>  array('p', array('class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array('p#my_id.my_class.another_class rel=my_rel title="my title"'),
    'result'  =>  array('p', array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array(' p#my_id.my_class.another_class  rel=my_rel  title="my title" '),
    'result'  =>  array('p', array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),
  /**
   *  elements with only inline attributes
   */
  array(
    'params'  =>  array('p rel=my_rel title="my title"'),
    'result'  =>  array('p', array())
  ),
  array(
    'params'  =>  array(' p  rel=my_rel  title="my title" '),
    'result'  =>  array('p', array())
  ),
  /**
   *  id and classes without element but with inline attributes
   */
  array(
    'params'  =>  array('#my_id rel=my_rel title="my title"'),
    'result'  =>  array(null, array('id' => 'my_id'))
  ),
  array(
    'params'  =>  array('.my_class rel=my_rel title="my title"'),
    'result'  =>  array(null, array('class' => 'my_class'))
  ),
  array(
    'params'  =>  array('.my_class.another_class rel=my_rel title="my title"'),
    'result'  =>  array(null, array('class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array('#my_id.my_class.another_class rel=my_rel title="my title"'),
    'result'  =>  array(null, array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),
  array(
    'params'  =>  array(' #my_id.my_class.another_class   rel=my_rel  title="my title" '),
    'result'  =>  array(null, array('id' => 'my_id', 'class' => 'my_class another_class'))
  ),

  /**
   * pure inline attributes
   */
  array(
    'params'  =>  array('rel=my_rel title="my title"'),
    'result'  =>  array(null, array())
  ),
  array(
    'params'  =>  array('  rel=my_rel  title="my title" '),
    'result'  =>  array(null, array())
  ),
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriterCssExpressionParser(), 'parse'));