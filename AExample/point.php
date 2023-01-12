<?php

class Point
{
    private int $x;

    private int  $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}

$p1 = new Point(10, 20);
$p2 = new Point(10, 20);

$p3 = $p1;

if ($p1 === $p2) {
    echo 'p1 and p2 are equal.';
} else {
    echo 'p1 and p2 are not equal.';
}

if ($p1 === $p3) {
    echo 'p1 and p3 are equal.';
} else {
    echo 'p1 and p2 are not equal.';
}