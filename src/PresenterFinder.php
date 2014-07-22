<?php namespace RyanNielson\Prez;

use RyanNielson\Prez\Exceptions\PresenterNotFoundException;

class PresenterFinder
{
    protected $object;

    protected $klass;

    public function __construct($object, $klass = null)
    {
        $this->object = $object;
        $this->klass = $klass;
    }

    public function presenter()
    {
        return $this->find();
    }

    public function rules()
    {
        return $this->find();
    }

    private function determineClassName()
    {
        return $this->klass ?: get_class($this->object) . 'Presenter';
    }

    private function find()
    {
        $className = $this->determineClassName();

        if (class_exists($className))
        {
            return new $className($this->object);
        }
        else
        {
            throw new PresenterNotFoundException("Unable to find presenter class: {$className}");
        }
    }
}
