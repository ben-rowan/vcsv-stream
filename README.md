# vcsv://stream

A virtual CSV stream for creating CSV fixtures for unit / integration testing.

## Usage

### Setup

In `setUp` call `VCsvStream::setup()` to initialise and register the stream wrapper.

```php
/**
 * @throws VCsvStreamException
 */
public function setUp()
{
    VCsvStream::setup();
}
```

### Header

Now that we've initialised the stream it's time to set up our CSVs header. We have 2 options here:

* `Header` - The header will be included in the stream
* `NoHeader`. The header won't be included in the stream

Both are configured in the same way so we'll stick with `Header` for the rest of this section.

```php
$header = new Header();

$header
    ->addValueColumn(self::HEADER_1, 1)
    ->addFakerColumn(self::HEADER_2, 'randomNumber', true)
    ->addColumn(self::HEADER_3);

VCsvStream::setHeader($header);
```

We're doing 3 things here:

* Telling CSV stream how many columns we want
* Telling CSV stream what the names of the columns should be (even if we're using `NoHeader`)
* Setting the default data generator for each column

#### Data Generators

##### Value

This type of column will always contain the value passed for `$value`.

`addValueColumn(string $name, $value)`

* `$name` - The name for this column
* `$value` - The value to be used for this column

##### Faker

This type of column will contain a random value generated by the
[Faker](https://github.com/fzaninotto/Faker) library.

`addFakerColumn(string $name, string $formatter, bool $isUnique = false)`

* `$name` - The name for this column
* `$formatter` - One of the [Faker](https://github.com/fzaninotto/Faker) libraries [formatters](https://github.com/fzaninotto/Faker#formatters)
* `$isUnique` - When set to `true` no 2 rows will have the same value for this column

##### Column

This type of column will contain a random `text` value generated by the
[Faker](https://github.com/fzaninotto/Faker) library.

`addColumn(string $name)`

* `$name` - The name for this column

### Record

Finally we add our CSV records (rows). We add these in chunks.

```php
$records = [];

$records[] = (new Record(10))
    ->addValueColumn(self::HEADER_2, 2)
    ->addFakerColumn(self::HEADER_3, 'randomNumber', false);

$records[] = (new Record(100))
    ->addValueColumn(self::HEADER_2, 3)
    ->addFakerColumn(self::HEADER_3, 'text', false);

$records[] = (new Record(1000))
    ->addValueColumn(self::HEADER_2, 4)
    ->addFakerColumn(self::HEADER_3, 'ipv4', false);

VCsvStream::addRecords($records);
```

The above would give us 10 of the first record type followed by 100 of the second and 1000 of
the third. The data generators added here take precedence over the default header data generators.
This means that we only need to configure the columns that we want to be different and don't need
to worry about the others (notice no config for `self::HEADER_1` above).

### Read

Now that we've setup the stream we can use it like we would any normal CSV file.

```php
$vCsv = new SplFileObject('vcsv://fixture.csv');

while ($row = $vCsv->fgetcsv()) {
    // ...
}
```