<?php

function php_html_writer_run_tests(lime_test $t, array $tests, $callable)
{
  foreach($tests as $test)
  {
    $parameters     = $test['params'];
    $expectedResult = isset($test['result']) ? $test['result'] : null;

    try
    {
      $result  = call_user_func_array($callable, $parameters);

      if(isset($test['throws']))
      {
        $t->fail($parameters[0].' throws a '.$test['throws']);
      }
      else
      {
        $t->is_deeply(
          $result,
          $expectedResult,
          '"'.$parameters[0].'" '.str_replace("\n", '', var_export($expectedResult, true))
        );
      }
    }
    catch(Exception $exception)
    {
      $exceptionClass = get_class($exception);

      $message = sprintf('"%s" throws a %s: %s',
        isset($parameters[0]) ? (string) $parameters[0] : 'NULL',
        $exceptionClass,
        $exception->getMessage()
      );

      if(isset($test['throws']) && $test['throws'] == $exceptionClass)
      {
        $t->pass($message);
      }
      else
      {
        $t->fail($message);
      }
    }
  }
}