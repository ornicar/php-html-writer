<?php

require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriterHelper.php';

$t = new lime_test(3);

$t->is(tag('div'), '<div></div>', 'render tag with helper');

$t->is(open('div'), '<div>', 'open tag with helper');

$t->is(close('div'), '</div>', 'close tag with helper');