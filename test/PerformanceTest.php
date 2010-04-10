<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpHtmlWriter.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$t = new lime_test(3);

$view = new phpHtmlWriter();
$nbTests  = 500;
$nbTags   = 10;

$t->is($view->tag('div'), '<div></div>', 'Writer is ready');

$startTime  = microtime(true);

for($iterator=0; $iterator<$nbTests; ++$iterator)
{
  $view->tag('div#my_id'.$iterator,
    $view->tag('ul.my_class'.$iterator,
      $view->tag('li.li_class', 'some content '.$iterator).
      $view->tag('li.li_class',
        $view->tag('input value="my value '.$iterator.'"')
      ).
      $view->tag('li', array('id' => 'my_id'),
        $view->tag('p', array('lang' => 'fr'), 'du contenu')
      )
    ).
    $view->open('div').
      'some text'.
      $view->tag('br').
    $view->close('div')
  );
}

$time = 1000 * (microtime(true) - $startTime);

$t->pass(sprintf(
  'Time to render %d nested tags: %0.2f milliseconds',
  $nbTests * $nbTags,
  $time
));

$t->pass(sprintf(
  'Time per tag: %0.3f milliseconds',
  $time/($nbTests * $nbTags)
));