<?php

use RyanNielson\Prez\Presenter;

class PresenterTests extends PHPUnit_Framework_TestCase {

    public function testGetValuesFromPresenter()
    {
        $presenter = new FooObjectPresenter(new FooObject);

        $this->assertEquals('foo FooObject', $presenter->label());
    }

    public function testCanGetObjectValuesAndMethodsThroughPresenter()
    {
        $presenter = new FooObjectPresenter(new FooObject);

        $this->assertEquals('foo', $presenter->name);
        $this->assertEquals('FooObject', $presenter->type);
        $this->assertEquals('PHP', $presenter->language());
    }

    public function testGetValuesFromPresenterWithPresents()
    {
        $presenter = new BarObjectPresenter(new BarObject);

        $this->assertEquals('bar', $presenter->name);
        $this->assertEquals('BarObject', $presenter->type);
        $this->assertEquals('bar BarObject', $presenter->label());
        $this->assertEquals('PHP', $presenter->language());
    }


           
}

class FooObject
{
    public $name = 'foo';
    public $type = 'FooObject';

    public function language()
    {
        return 'PHP';
    }
}

class BarObject
{
    public $name = 'bar';
    public $type = 'BarObject';

    public function language()
    {
        return 'PHP';
    }
}

class FooObjectPresenter extends Presenter
{
    public function label()
    {
        return "{$this->object->name} {$this->object->type}";
    }
}

class BarObjectPresenter extends Presenter
{
    protected $presents = 'bar';

    public function label()
    {
        return "{$this->bar->name} {$this->object->type}";
    }

    public function language()
    {
        return $this->bar->language();
    }
}
