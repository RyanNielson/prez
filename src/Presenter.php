<?php namespace RyanNielson\Prez;

use RyanNielson\Prez\Exceptions\InvalidPresenterPresentsException;

class Presenter
{
    protected $object;

    protected $presents = null;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->object, $name], $arguments);
    }

    public function __get($name)
    {
        return $this->presents === $name ? $this->object : $this->object->{$name};
    }
}
