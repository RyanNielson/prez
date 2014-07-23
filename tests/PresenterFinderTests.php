<?php

use RyanNielson\Prez\PresenterFinder;

class PresenterFinderTests extends PHPUnit_Framework_TestCase
{
    public function testGetPresenterUsingObject()
    {
        $presenterFinder = new PresenterFinder(new Foo);
        $this->assertInstanceOf('FooPresenter', $presenterFinder->presenter());
    }

    public function testGetPresenterUsingString()
    {
        $presenterFinder = new PresenterFinder(new Foo, 'BarPresenter');
        $this->assertInstanceOf('BarPresenter', $presenterFinder->presenter());
    }

    /**
     * @expectedException        RyanNielson\Prez\Exceptions\PresenterNotFoundException
     * @expectedExceptionMessage Unable to find presenter class: BazPresenter
     */
    public function testThrowExceptionWhenPresentNotFound()
    {
        $presenterFinder = new PresenterFinder(new Baz);
        $presenterFinder->presenter();
    }
}

class Foo
{
}

class Baz
{
}

class FooPresenter
{
}

class BarPresenter
{
}
