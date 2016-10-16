<?php

namespace Dhii\Collection;

/**
 * Common functionality for collections that can have its items removed.
 *
 * Provides functionality necessary for implementation of {@see RemovalCapableCollectionInterface}.
 *
 * @since [*next-version*]
 */
class AbstractRemovalCapableCollection extends AbstractWritableCollection
{
    /**
     * Removes the given item from this collection.
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item to remove.
     *
     * @return bool True if removal successful; false if failed.
     */
    protected function _removeItem($item)
    {
        if (($key = $this->_findItem($item, true)) !== false) {
            return $this->_arrayUnset($this->items, $key);
        }

        return false;
    }

    /**
     * Remove given items from this collection.
     *
     * @since [*next-version*]
     *
     * @param mixed[]|\Traversable $items
     *
     * @return bool False if at least one of the items could not be removed; true otherwise.
     */
    protected function _removeMany($items)
    {
        $isSuccess = true;
        foreach ($items as $_item) {
            $isSuccess = $this->_removeItem($_item) && $isSuccess;
        }

        return $isSuccess;
    }

    /**
     * Unset the specified key in the given list.
     *
     * @since [*next-version*]
     *
     * @param mixed[]|\ArrayAccess|MutableCollectionInterface $list The list, for which to set the value.
     * @param string                                          $key  The key, for which to unset the item.
     *
     * @throws RuntimeException If list is not something that can have a value unset.
     *
     * @return bool True if the value has been successfully unset; false if unsetting failed.
     */
    protected function _arrayUnset(&$array, $key)
    {
        if (is_array($array)) {
            if (isset($array[$key])) {
                unset($array[$key]);

                return true;
            }

            return false;
        }

        if ($array instanceof \ArrayAccess) {
            if ($array->offsetExists($key)) {
                $array->offsetUnset($key);

                return true;
            }

            return false;
        }

        if ($array instanceof MutableCollectionInterface) {
            return $array->removeItemByKey($key);
        }

        throw new RuntimeException(sprintf(
            'Could not unset list item for key "%1$s": the list is not something that can have an item unset', $key));
    }
}
