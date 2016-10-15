<?php

namespace Dhii\Collection;

/**
 * Common functionality for collections that can have items retrieved.
 * 
 * Provides functionality necessary for implementation of {@see ReadableCollectionInterface}.
 * 
 * @since [*next-version*]
 */
class AbstractReadableCollection extends AbstractTraversableCollection
{
    /**
     * Retrieve an item with the specified key from this collection.
     *
     * @since [*next-version*]
     *
     * @param string|int $key     The key to get an item for.
     * @param mixed      $default The value to return if the specified key does not exists.
     *
     * @return mixed|null The item at the specified key, if it exists; otherwise, the default value.
     */
    protected function _getItem($key, $default = null)
    {
        return $this->_arrayGet($this->_getCachedItems(), $key, $default);
    }

    /**
     * Retrieves an item with the specified key from the given list.
     *
     * @since [*next-version*]
     *
     * @param array|\ArrayAccess|AccessibleCollectionInterface $list The list to retrieve from.
     * @param string|int                                       $key  The key to retrieve the item for.
     *
     * @throws RuntimeException If list is not something that can have a value retrieved by key.
     *
     * @return mixed|null The item at the specified key.
     */
    protected function _arrayGet(&$list, $key, $default = null)
    {
        if (is_array($list)) {
            return isset($list[$key])
                ? $list[$key]
                : $default;
        }

        if ($list instanceof \ArrayAccess) {
            return $list->offsetExists($key)
                ? $list->offsetGet($key)
                : $default;
        }

        if ($list instanceof AccessibleCollectionInterface) {
            return $list->hasItemKey($key)
                ? $list->getItem($key)
                : $default;
        }

        throw $this->_createRuntimeException(sprintf(
            'Could not get list item for key "%1$s": the list is not something that can have an item retrieved', $key));
    }
}
