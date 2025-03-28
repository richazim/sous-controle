<?php

use SousControle\Core\ErrorHandler;

it('transforms error to error exception', function(){
    $error_number = 0;
    $error_line = 20;
    expect(fn() => ErrorHandler::transformErrorToException($error_number, 'message_test', 'file_name_test.php', $error_line))
        ->toThrow(new ErrorException('message_test', 0, $error_number, 'file_name_test.php', $error_line));
});