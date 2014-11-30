ABCode
======

ab testing for code

## Example 1
```php
<?php

require 'vendor/autoload.php';

$experiment = new Gil\ABCode\DefaultExperiment('test-one');

$test = new Gil\ABCode\Test($experiment);


$test
	->setControl(function() {

		return User::find(10);

	})
	->setCandidate(function() {

		return (new UserService)->findById(10);

	});

$test->run(true);
```

## Example 2
```php
<?php

require 'vendor/autoload.php';

$experiment = new Gil\ABCode\DefaultExperiment('test-two');

$test = new Gil\ABCode\Test($experiment);


$test
	->setControl(function() {

		usleep(200);

		return [1, 2, 3, 4, 5, 6];

	}, function ($result) {

		return array_reduce($result, function($carry, $item) {
			$carry += $item;
    		return $carry;
		});	

	})
	->setCandidate(function() {

		usleep(100);

		return [1, 2, 3, 4, 5, 6];

	}, function ($result) {

		return array_reduce($result, function($carry, $item) {
			$carry += $item;
    		return $carry;
		});	

	})
	->runIf(function(){
		return true;
	});

$test->run(true);
```
