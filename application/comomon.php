<?php
function test()
{
    return 11;
}

function logic1($name = '')
{
    echo  "new \\app\\common\\logic\\$name()";exit;
}