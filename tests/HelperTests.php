<?php

class HelperTests extends PHPUnit_Framework_TestCase
{
    public function testGetPresenterUsingObject()
    {
        $this->assertInstanceOf('FooHelperPresenter', presenter(new FooHelper));
    }

    public function testGetPresenterUsingString()
    {
        $this->assertInstanceOf('FooHelperPresenter', presenter(new BarHelper, 'FooHelperPresenter'));
    }
}

class FooHelper
{
}

class BarHelper
{
}

class FooHelperPresenter
{
}
