<?php

namespace Dhii\Collection;

/**
 * Basic common functionality for collections that can have the bulk of items retrieved.
 * 
 * Provides functionality necessary for implementation of {@see BulkRetrievableCollectionInterface}.
 * 
 * @since [*next-version*]
 */
abstract class AbstractBulkRetrievableCollection extends AbstractValidateCapableCollection
{
    protected $cachedItems;

    /**
     * Low-level retrieval of all items.
     *
     * @since [*next-version*]
     *
     * @return mixed[]|\Traversable
     */
    protected function _getItems()
    {
        return $this->_getRawItems();
    }

    /**
     * Retrieve a cachedset of items.
     *
     * If no items are cached, populates the cache first.
     * This is particularly useful if the items require post-processing,
     * and will be accessed multiple times.
     *
     * @since [*next-version*]
     *
     * @return array The array of items.
     */
    protected function &_getCachedItems()
    {
        if (is_null($this->cachedItems)) {
            $this->cachedItems = $this->_getItemsForCache();
        }

        return $this->cachedItems;
    }

    /**
     * Retrieves items that are prepared to be cached and worked with.
     *
     * @since [*next-version*]
     *
     * @return array The array of prepared items.
     */
    protected function _getItemsForCache()
    {
        $items = $this->_getItems();

        return $items;
    }

    /**
     * Clears and resents the iterable item cache.
     *
     * @since [*next-version*]
     *
     * @return AbstractIterableCollection This instance.
     */
    protected function _clearItemCache()
    {
        $this->cachedItems = null;

        return $this;
    }

    /**
     * Normalize an array-ish value to array.
     *
     * @since [*next-version*]
     *
     * @param array|AbstractCollection|\Traversable $list The list, which to convert.
     *
     * @throws RuntimeException If list is not something that can have a value unset.
     *
     * @return array The array that resulted from the conversion.
     *               If the argument is an array, returns unmodified.
     *               If it is an {@see AbstractCollection} and not a {@see \Traversable}, gets its internal items and tries to convert those to array.
     *               If it is a {@see \Traversable}, returns the result of {@see iterator_to_array()} on that.
     */
    protected function _arrayConvert(&$list)
    {
        if (is_array($list)) {
            return $list;
        }

        if ($list instanceof self && !($list instanceof BulkRetrievableCollectionInterface)) {
            $items = $list->getItems();

            return $this->_arrayConvert($items);
        }

        if ($list instanceof \Traversable) {
            return iterator_to_array($list, true);
        }

        throw $this->_createRuntimeException(sprintf(
            'Could not convert to array: not something that can be converted'));
    }
}
