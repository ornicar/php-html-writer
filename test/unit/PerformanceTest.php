<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriter.php';
require_once dirname(__FILE__).'/phpHtmlWriterTestHelper.php';

$t = new lime_test(1);

$view = new phpHtmlWriter();
$nbTests  = 50;
$nbTags   = 10;

$start = microtime(true);

for($i=0; $i<$nbTests; ++$i)
{
  $view->tag('div#my_id',
    $view->tag('ul.my_class',
      $view->tag('li', 'some content').
      $view->tag('li',
        $view->tag('input value="my value"')
      ).
      $view->tag('li',
        $view->tag('p', 'some content')
      )
    )
  );
  $view->open('div#my_id.my_class');
  $view->close('div');
  $view->tag('br');
}

$time = microtime(true) - $start;

$t->pass(sprintf(
  'Time to render %d nested tags: %0.2f seconds',
  $nbTests * $nbTags,
  $time
));