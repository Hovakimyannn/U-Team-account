<?php

$a = 5;
$b = 5;

function foo() {
    return 5.0;
};

$c = foo();
var_dump($a == $b);
var_dump($a === $b);
var_dump($a == $c);
var_dump($a === $c);


