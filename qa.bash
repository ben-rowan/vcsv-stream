#!/usr/bin/env bash

echo "
Running PHPStan
";

./vendor/bin/phpstan analyse --level=max src/;
./vendor/bin/phpstan analyse --level=max tests/;

echo "
Running tests
";

./vendor/bin/phpunit tests/;