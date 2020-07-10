<?php
declare(strict_types=1);

namespace Gusarov112\AbstractCollection;

use Countable;
use Generator;
use IteratorAggregate;
use JsonSerializable;
use SplFixedArray;
use function count;

/**
 * You can add your own type-hinted constructor and method to add items
 */
abstract class AbstractCollection implements IteratorAggregate, JsonSerializable, Countable
{
    protected $items = [];

    public function getIterator(): SplFixedArray
    {
        return SplFixedArray::fromArray(isset($this->items[0]) ? $this->items : array_values($this->items));
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function sort(callable $sortCallback): void
    {
        usort($this->items, $sortCallback);
    }

    public function getFilteredCopy(callable $condition): self
    {
        $filteredCollection = new static();

        foreach ($this as $item) {
            if ($condition($item)) {
                $filteredCollection->items[] = $item;
            }
        }

        return $filteredCollection;
    }

    public function getItemsGenerator(?callable $condition): Generator
    {
        return (function (?callable $condition) {
            foreach ($this as $item) {
                if (is_null($condition) || $condition($item)) {
                    yield $item;
                }
            }
        })(
            $condition
        );
    }

    public function reduce(callable $condition): void
    {
        foreach ($this->items as $key => $item) {
            if (!$condition($item)) {
                unset($this->items[$key]);
            }
        }
        if (isset($this->items[0])) {
            $this->items = array_values($this->items);
        }
    }
}
