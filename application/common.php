<?php
function test()
{
    return 11;
}

function logic($name = '')
{
    return  "new \\app\\common\\logic\\$name()";
}