<?php
function dd($data){
    var_dump($data);
    die();
}


//function sum($a, $b=1, $c){
//    return $a+$b+$c;
//}
//
//dd(sum(1, 4 ));


class Str
{
    private $s = '';

    private $functions = [
        'upper' => 'strtoupper',
        'lower' => 'strtolower'
        // map more method to functions
    ];

    public function __construct(string $s)
    {
        $this->s = $s;
    }

    public function __call($method, $args)
    {
        if (!in_array($method, array_keys($this->functions))) {
            throw new BadMethodCallException();
        }

        array_unshift($args, $this->s);

        return call_user_func_array($this->functions[$method], $args);
    }
}

$s = new Str('Hello, World!');

echo $s->upper() . "\n"; // HELLO, WORLD!
echo $s->lower() . "\n"; // hello, world!
echo $s->length() . "\n"; // 13