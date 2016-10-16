<?php

namespace Dhii\Collection;

/**
 * Basic common functionality for collections that can retrieve the amount of items in it.
 * 
 * Provides functionality necessary for implementation of {@see CountableCollectionInterface}.
 * 
 * @since [*next-version*]
 */
abstract class AbstractCountableCollection extends AbstractBulkRetrievableCollection
{
    /**
     * Retrieve the amount of items that this instance is currently storing.
     * 
     * @since [*next-version*]
     * 
     * @return int The amount of items.
     */
    protected function _count()
    {
        $items = $this->_getCachedItems();

        return $this->_arrayCount($items);
    }

    /**
     * Get the amount of all elements in the given list.
     *
     * @since [*next-version*]
     *
     * @param array|\Countable|\Traversable $array The list to get the count of.
     *
     * @throws RuntimeException If the given list is not something that can be counted.
     *
     * @return int The number of items in the list.
     */
    public function _arrayCount(&$list)
    {
        if (is_array($list)) {
            return count($list);
        }

        if ($list instanceof \Countable) {
            return $list->count();
        }

        if ($list instanceof \Traversable) {
            $count = 0;
            $list  = $this->_getIterator($list);
            foreach ($list as $_item) {
                ++$count;
            }

            return $count;
        }

        throw $this->_createRuntimeException(sprintf('Could not count elements: the given list is not someting that can be counted'));
    }
}
