<?php

require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpHtmlWriterHelper.php';

$t = new lime_test();

$t->is((string) tag('div'), '<div></div>', 'the helper works');