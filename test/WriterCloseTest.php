<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpHtmlWriter.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$tests = array(
  /**
   *  pure elements
   */
  array(                          // one test
    'params'  =>  array('div'),   // ->tag() parameters
    'result'  =>  '</div>'        // expected result
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
  array(
    'params'  =>  array('#my_id'),
    'throws'  =>  'InvalidArgumentException'
  ),
  array(
    'params'  =>  array('.my_class.another.class'),
    'throws'  =>  'InvalidArgumentException'
  ),
  array(
    'params'  =>  array('input'),
    'throws'  =>  'LogicException'
  ),
  /**
   *  elements with id and classes
   */
  array(
    'params'  =>  array('p#my_id'),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('p.my_class'),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('p.my_class.another_class'),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('p#my_id.my_class.another_class'),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array(' p#my_id.my_class.another_class '),
    'result'  =>  '</p>'
  ),
  /**
   * Elements with parameters
   */
  array(
    'params'  =>  array('div', array('id' => 'my_id')),
    'result'  =>  '</div>'
  ),
  array(
    'params'  =>  array('p', array('class' => 'my_class')),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('p', array('class' => 'my_class another_class')),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('p', array('id' => 'my_id', 'class' => 'my_class another_class')),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array(' p ', array('id' => ' my_id ', 'class' => ' my_class another_class ')),
    'result'  =>  '</p>'
  ),
  array(
    'params'  =>  array('a', array('href' => 'http://diem-project.org/')),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class', array('href' => 'http://diem-project.org/')),
    'result'  =>  '</a>'
  ),
  /**
   * Elements with parameters and content
   */
  array(
    'params'  =>  array('div', array('id' => ' my_id ', 'class' => ' my_class another_class ')),
    'result'  =>  '</div>'
  )
  /**
   * Elements with id, classes and parameters
   */,
  array(
    'params'  =>  array('a#my_id.my_class.another_class', array('href' => 'http://diem-project.org/')),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class', array('id' => 'changed_id', 'href' => 'http://diem-project.org/')),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class', array('class' => 'added_class other_added_class', 'href' => 'http://diem-project.org/')),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class', array('class' => 'added_class other_added_class my_class', 'href' => 'http://diem-project.org/', 'title' => 'my title')),
    'result'  =>  '</a>'
  ),
  /**
   * Elements inline attribute
   */
  array(
    'params'  =>  array('a href="http://diem-project.org/"'),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a class=my_class'),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class href="http://diem-project.org/"'),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class id=changed_id href="http://diem-project.org/"'),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class class="added_class other_added_class" href="http://diem-project.org/"'),
    'result'  =>  '</a>'
  ),
  array(
    'params'  =>  array('a#my_id.my_class.another_class class="added_class other_added_class my_class" href="http://diem-project.org/" title="my title"'),
    'result'  =>  '</a>'
  )
);

$t = new lime_test(count($tests));

php_html_writer_run_tests($t, $tests, array(new phpHtmlWriter(), 'close'));