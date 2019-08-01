#!/usr/bin/env bash

echo "
Running tests
";
./vendor/bin/phpunit tests/;

echo "
Running PHPStan
";

./vendor/bin/phpstan analyse --level=max src/;
./vendor/bin/phpstan analyse --level=max tests/;
