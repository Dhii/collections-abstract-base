<?php

namespace Dhii\Collection;

/**
 * Common functionality for collections that can be checked for existence of an item by key.
 * 
 * Provides functionality necessary for implementation of {@see CheckCapableCollectionInterface}.
 * 
 * @since [*next-version*]
 */
abstract class AbstractCheckCapableCollection extends AbstractCountableCollection
{
    /**
     * Checks whether an item with the specified key exists in this collection.
     *
     * @since [*next-version*]
     *
     * @param int|string $key The key to check for.
     *
     * @return bool True if the key exists in this collection; false otherwise.
     */
    protected function _hasItemKey($key)
    {
        $items = $this->_getItems();
        return $this->_arrayKeyExists($items, $key);
    }

    /**
     * Checks if an item with the specified key exists in a list.
     *
     * @since [*next-version*]
     *
     * @param array|\ArrayAccess|AccessibleCollectionInterface $list The list to check.
     * @param string|int                                       $key  The key to check for.
     *
     * @throws RuntimeException If list is not something that can have a key checked.
     *
     * @return bool True if an item with the specified key exists the given list; otherwise false.
     */
    protected function _arrayKeyExists(&$list, $key)
    {
        if (is_array($list)) {
            return array_key_exists($key, $list);
        }

        if ($list instanceof \ArrayAccess) {
            return $list->offsetExists($key);
        }

        if ($list instanceof AccessibleCollectionInterface) {
            return $list->hasItemKey($key);
        }

        throw $this->_createRuntimeException(sprintf(
            'Could not check list for key "%1$s": the list is not something that can have an item checked', $key));
    }
}
