<?php

namespace Dhii\Collection;

use RuntimeException;
use UnexpectedValueException;

/**
 * Common functionality for collections that can be iterated over in a foreach loop.
 * 
 * Provides functionality necessary for implementation of {@see TraversableCollectionInterface}.
 *
 * Caches items on rewind, allowing convenient auto-generation of items,
 * while still having performance in the loop.
 *
 * @since [*next-version*]
 */
abstract class AbstractTraversableCollection extends AbstractCheckCapableCollection
{
    /**
     * Retrieves the current element in the iteration.
     *
     * @since [*next-version*]
     */
    protected function _current()
    {
        return $this->_arrayCurrent($this->_getCachedItems());
    }

    /**
     * Retrieves the key of the current element in the iteration.
     *
     * @since [*next-version*]
     */
    protected function _key()
    {
        return $this->_arrayKey($this->_getCachedItems());
    }

    /**
     * Advances the internal iteration pointer forward.
     *
     * @since [*next-version*]
     */
    protected function _next()
    {
        $this->_arrayNext($this->_getCachedItems());
    }

    /**
     * Returns the internal iteration pointer to the beginning.
     *
     * @since [*next-version*]
     */
    protected function _rewind()
    {
        $this->_arrayRewind($this->_getCachedItems());
    }
    
    /**
     * Determines whether or not the current item is valid.
     * 
     * @since [*next-version*]
     * 
     * @return bool True if the current element is valid, e.g. exists; otherwise false.
     */
    protected function _valid()
    {
        return $this->_arrayKey($this->_getCachedItems()) !== null;
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
        $items = parent::_getItemsForCache();
        $this->_arrayRewind($items);

        return $items;
    }

    /**
     * Retrieve the current element from a list.
     *
     * @since [*next-version*]
     *
     * @param array|\Traversable $array The list to get the current element of.
     *
     * @return mixed The current element in the list.
     */
    protected function _arrayCurrent(&$array)
    {
        return $array instanceof \Traversable
            ? $this->_getIterator($array)->current()
            : current($array);
    }

    /**
     * Retrieve the current key from a list.
     *
     * @since [*next-version*]
     *
     * @param array|\Traversable $array The list to get the current key of.
     *
     * @return string|int The current key in the list.
     */
    protected function _arrayKey(&$array)
    {
        return $array instanceof \Traversable
            ? $this->_getIterator($array)->key()
            : key($array);
    }

    /**
     * Move the pointer of the list to the beginning.
     *
     * @since [*next-version*]
     *
     * @param array|\Traversable $array The list to rewind.
     *
     * @return mixed|bool The value of the first list item.
     */
    protected function _arrayRewind(&$array)
    {
        return $array instanceof \Traversable
            ? $this->_getIterator($array)->rewind()
            : reset($array);
    }

    /**
     * Move the pointer of the list forward and return the element there.
     *
     * @since [*next-version*]
     *
     * @param array|\Traversable $array The list to move the pointer of.
     *
     * @return mixed|null The element at the next position in the list.
     */
    protected function _arrayNext(&$array)
    {
        return $array instanceof \Traversable
            ? $this->_getIterator($array)->next()
            : next($array);
    }

    /**
     * Retrieve the bottom-most iterator of this iterator.
     *
     * If this is an iterator, gets itself.
     * If this is an {@see \IteratorAggregate}, return its inner-most iterator, recursively.
     *
     *
     * @since [*next-version*]
     *
     * @param \Traversable $iterator An iterator.
     *
     * @return \Iterator The final iterator.
     */
    protected function _getIterator(\Traversable $iterator)
    {
        if ($iterator instanceof \Iterator) {
            return $iterator;
        }

        if (!($iterator instanceof \IteratorAggregate)) {
            throw $this->_createUnexpectedValueException(sprintf('Could not retrieve iterator'));
        }

        $this->_getIterator($iterator->getIterator());
    }
}
