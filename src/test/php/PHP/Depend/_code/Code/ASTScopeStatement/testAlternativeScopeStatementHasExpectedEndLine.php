<?php
function testAlternativeScopeStatementHasExpectedEndLine(array $values)
{
    foreach ($values as $value)

            :
        if ($value < 42):
            echo 'Less than 42', PHP_EOL;
        elseif ($value === 42):
            echo 'Exactly 42', PHP_EOL;
        else:
            echo 'Something else', PHP_EOL;
        endif
            /* ... */
                ;

    endforeach;
}

testAlternativeScopeStatementHasExpectedEndLine(rand(22, 43));