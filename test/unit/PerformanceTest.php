<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriter.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$t = new lime_test(3);

$view = new phpHtmlWriter();
$nbTests  = 50;
$nbTags   = 10;

$t->is($view->tag('div#my_id', 'content'), '<div id="my_id">content</div>', 'Writer is ready');

$start = microtime(true);

for($iterator=0; $iterator<$nbTests; ++$iterator)
{
  $view->tag('div#my_id'.$iterator,
    $view->tag('ul.my_class'.$iterator,
      $view->tag('li', 'some content '.$iterator).
      $view->tag('li',
        $view->tag('input value="my value '.$iterator.'"')
      ).
      $view->tag('li',
        $view->tag('p', 'some content')
      )
    ).
    $view->open('div#my_id.my_class').
      'some text'.
      $view->tag('br').
    $view->close('div')
  );
}

$time = 1000 * (microtime(true) - $start);

$t->pass(sprintf(
  'Time to render %d nested tags: %0.2f milliseconds',
  $nbTests * $nbTags,
  $time
));

$t->pass(sprintf(
  'Time per tag: %0.2f milliseconds',
  $time/($nbTests * $nbTags)
));