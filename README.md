# vcsv://stream

A virtual CSV stream for creating unit / integration test fixtures.

## Install

```bash
composer require --dev ben-rowan/vcsv-stream
```

## Modes

You can generate CSV fixtures in two modes with vcsv://stream, online and offline.

### Online

You can use vcsv://stream as a direct replacement for your standard file stream. In this mode
vcsv://stream will dynamically generate fake CSV data based on the provided configuration.

pros:
* Fast test development / feedback loop.
* Each test run get's a different set of valid data. This means you have the chance to catch
  unexpected bugs in your code.
  
cons:
* Higher CPU and memory utilisation when generating large files (I'll see if I can reduce this!)

### Offline

You can also use vcsv://stream to generate a CSV fixture on disk. You can then use this later in
your test.

pros:
* Fast test execution with reduced CPU and memory load.

cons:
* Slower test development / feedback loop.
* Each test run get's the same data. This reduces the scope of your testing.

## Usage

### Online

The first step is to call vcsv://streams setup method in your test. This initialises and
registers the stream:

```php
/**
 * @throws VCsvStreamException
 */
public function setUp()
{
    VCsvStream::setup();
}
```

Next you load your configuration (see [here]() for config docs):

```php
/**
 * @test
 *
 * @throws ValidationException
 * @throws ParserException
 */
public function iCanTestSomething(): void
{
    VCsvStream::loadConfig('path/to/config.yaml');

    // ...
}
```

Finally you can use the stream as you would any other file stream:

```php
/**
 * @test
 *
 * @throws ValidationException
 * @throws ParserException
 */
public function iCanTestSomething(): void
{
    VCsvStream::loadConfig('path/to/config.yaml');

    $vCsv = new SplFileObject('vcsv://fixture.csv');

    // ...
}
```

### Offline

The provided `generate:csv` command makes this easy:

```bash
vendor/bin/vcsv generate:csv path/to/config.yaml
```

This will output a CSV file to `stdout` so you can easily see what's being generated. Once you're
happy you can dump it to disk:

```bash
vendor/bin/vcsv generate:csv path/to/config.yaml > some_fixture.csv
```

## Configuration

vcsv://stream uses yaml configuration files to define your CSV fixtures. This has many benifits
over simply creating CSV files and adding them to source control:

* You're defining the _rules_ for what get's generated. This means you know you have 100 rows
  of this type of data followed by 100 rows of another. If you just have the CSV then you have to
  guess this or get the information from a separate set of documentation.
* You can add comments. This means you can describe the fixture in detail
  at the top as well as commenting choices you've made throughout. This is a big help.
* You can easily edit the CSV from your IDE / text editor. This reduces the overhead of making
  changes as you develop your test (this is particularly true for the online mode).
  
### Example

Here's a complete example of some vcsv://stream configuration. We'll go through each section
below:

```yaml
# This CSV is used to test for X, Y and Z

header:
  include: true
  columns:
    "Column One":
      type: value
      value: 1
    "Column Two":
      type: faker
      formatter: randomNumber
      unique: true
    "Column Three":
      type: text
records:
  "Record One":
    count: 10
    columns:
      "Column Two":
        type: value
        value: 2
      "Column Three":
        type: faker
        formatter: randomNumber
        unique: false
  # This record is important for some reason
  "Record Two":
    count: 100
    columns:
      "Column Two":
        type: value
        value: 3  # This is why we chose 3
      "Column Three":
        type: faker
        formatter: text
        unique: false
  "Record Three":
    count: 1000
    columns:
      "Column Two":
        type: value
        value: 4
      "Column Three":
        type: faker
        formatter: ipv4
```

### `header`

This section defines the header for your CSV. It's required even if you choose not to output
a header because it defines the default data generators for each of the columns.

#### `include`

When set to `true` the CSV will include a header. When set to `false` it wont.

#### `columns`

This is how we tell vcsv://stream how many columns we'd like to give our CSV and how to generate
data for those columns by default.
 
The name provided for each column will become the columns header if this is enabled. The names must
be unique.

```yaml
header:
  columns:
    "Column Name":  # <-- column name
      type: text    # <-- column data generation config
```

vcsv://stream can generate data in three ways:

#### `value` Columns

You can provide a fixed value that you'd like this column to contain:

```yaml
"Column Name":
  type: value
  value: 1
```

#### `faker` Columns

You can randomly generate data using one of the
[Faker](https://github.com/fzaninotto/Faker) libraries
[formatters](https://github.com/fzaninotto/Faker#formatters):

```yaml
"Column Name":
  type: faker
  formatter: randomNumber
  unique: true
```

By setting `unique` to `true` we're telling [Faker](https://github.com/fzaninotto/Faker)
that we don't want this column to contain any duplicate data.

#### `text` Columns

You can also tell vcsv://stream that you'd just like the column to contain lorem ipsum:

```yaml
"Column Name":
  type: text
```

### `records`

This defines the actual CSV data. We define the data in 'chunks' meaning we can vary the
data throughout the file. Each record has a name, this should be something that helps you
remember why it was created.

```yaml
records:
  "Record One":     # <-- record name
    count: 10       # <-- number of rows to generate with this config
    columns:
      "Column Two": # <-- override the data generator for 'Column Two'
        type: value
        value: 2
```

#### `count`

This defines the number of rows that should be created using this set of config.

#### `columns`

This defines a set of override data generators for the columns. If we don't define
a column here then the previously configured default header generator will be used.

Note: the column names here _must_ match one of the header columns.