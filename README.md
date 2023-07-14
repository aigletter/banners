### Install

Composer: add repository and required package to your composer.json and install dependencies
```json
{
  "require": {
    "aigletter/banners": "dev-master"
  },
  "repositories": [
    {
      "type":  "github",
      "url": "git@github.com:aigletter/banners.git"
    }
  ]
}
```

### Usage

```php
$repository = new DatabaseRepository(
    'mysql:dbname=dbname;host=127.0.01',
    'user',
    'password'
);

$service = new Service($repository,);

$renderer = $service->show(__DIR__ . '/banner.jpg');

$renderer->render();
```

See [examples](https://github.com/aigletter/banners/tree/master/examples)