#Prez

[![Build Status](https://travis-ci.org/RyanNielson/prez.svg?branch=master)](https://travis-ci.org/RyanNielson/prez)
[![Total Downloads](https://poser.pugx.org/ryannielson/prez/downloads.svg)](https://packagist.org/packages/ryannielson/prez)
[![Latest Stable Version](https://poser.pugx.org/ryannielson/prez/v/stable.svg)](https://packagist.org/packages/ryannielson/prez)
[![Latest Unstable Version](https://poser.pugx.org/ryannielson/prez/v/unstable.svg)](https://packagist.org/packages/ryannielson/prez)
[![License](https://poser.pugx.org/ryannielson/prez/license.svg)](https://packagist.org/packages/ryannielson/prez)

Simple presenters for your PHP or Laravel project.

## Why Should I Use Presenters?

Imagine your application has a `User` model. With Prez, you'd create a matching `UserPresenter` class. This presenter wraps the model, dealing with only presentational concerns. This keeps any view related logic out of the model, while also helping you keep logic out of the view. In your view you can use the presenter in the same way you'd use the original model. Whenever you start thinking about creating a helper function or adding logic to your view, it might be worth moving it into a presenter.

## Installation

Run the following Composer command in your terminal, or simply add `"ryannielson/prez": "~1.0.0"` to your composer.json file:

    composer require ryannielson/prez:'~1.0.0'

Once complete, if using Laravel, you now have to add the the service provider to the providers array in `app/config/app.php`: 

    'RyanNielson\Prez\PrezServiceProvider'

## Usage

### Creating Presenters

Presenters inherit from `RyanNielson\Prez\Presenter`, and should be named for the model they present. In Laravel these should live in the `app/presenters` directory.

```php
// app/presenters/UserPresenter.php
class UserPresenter extends RyanNielson\Prez\Presenter 
{
}
```

### Laravel Commands

Prez includes a command to automate the creation of Presenters. 

To create a presenter called `UserPresenter` in `app/presenters`:

`php artisan prez:presenter User`

To create a presenter called `UserPresenter` in `app/custom`:

`php artisan prez:presenter User --path=app/custom`

### Accessing the Object in a Presenter

You can access the wrapped object in a presenter by using `$this->object`. This allows you get get any public property or call any public function on the object.

```php
class UserPresenter extends RyanNielson\Prez\Presenter 
{
    public function fullName()
    {
        return $this->object->firstName . ' ' . $this->object->lastName;
    }
}
```

You can also use the `presents` property on the presenter so that you can using a name other than `$this->object` to access the object. This makes the presenter code a bit more clear.

```php
class UserPresenter extends RyanNielson\Prez\Presenter 
{
    // This allows us to use $this->user instead of $this->object
    protected $presents = 'user'; 

    public function fullName()
    {
        return $this->user->firstName . ' ' . $this->user->lastName;
    }
}
```

### Getting a Presenter for an Object

By default, Prez assumes that your presenter class uses your object's class name followed by presenter. For example, an object with the class `User` is assumed to have a corresponding `UserPresenter` class. The `presenter` helper method uses this assumption to find your presenter and return an instance of it.

```php
$user = new User;
$userPresenter = presenter($user); // Returns an instance of UserPresenter
```

`presenter` also takes an optional class name if you want to force a specific presenter to be used.

```php
$user = new User;
$userPresenter = presenter($user, 'AdminPresenter'); // Returns an instance of AdminPresenter
```

If you prefer not to use the helper function, you can explicitily pass your object when constructing a presenter.

```php
$user = new User;
$userPresenter = new UserPresenter($user);
```

### Using a Presenter in a View

If you have a presenter object passed to your view, you can use your presenter like any other object. The following example assumes the usage of Laravel's blade template language.

```php
<!-- Assuming you have a $userPresenter available in the view. -->
<h1>{{ $userPresenter->fullName() }}</h1>
```

### Delegating to Object

If the presenter doesn't contain a property or method, the call is delegated to the wrapped object. This makes it so that if we want to access a field on the model, we don't have to write a function in the presenter.

```php
class User
{
    public $name = 'Ryan';

    public function language()
    {
        return 'PHP';
    }
}

class UserPresenter extends RyanNielson\Prez\Presenter 
{
}

$userPresenter = new UserPresenter(new User);

// Since no method or property exists on presenter, these flow to the object.
$userPresenter->name; 
$userPresenter->language();
```
