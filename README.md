# Abstract Collection

## Installation

Add github repository to composer.json
```json
{
   "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:gusarov112/abstract-collection"
        }
    ]
}
```
Than require package
```bash
composer require gusarov112/abstract-collection
```

## Usage

This is just recommendation how to use and how to implement.

```php

/**
 * @method Bar[] getIterator()
 */
class BarCollection extends \Gusarov112\AbstractCollection\AbstractCollection
{
    public function __construct(Bar ...$items)
    {
        $this->items = $items;
    }

    public function addItem(Bar $item)
    {
        $this->items[] = $item;
    }
}

```

# @TODO

1. Write tests
2. Make SplFixedArray benchmark again and post results in readme
