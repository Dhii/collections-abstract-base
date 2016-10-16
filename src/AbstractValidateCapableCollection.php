<?php

namespace Dhii\Collection;

/**
 * Basic common functionality for collections.
 *
 * Provides functionality necessary for implementation of
 * {@see ValidateCapableCollectionInterface} and {@see KeyValidateCapableCollectionInterface}.
 *
 * @since [*next-version*]
 */
abstract class AbstractValidateCapableCollection extends AbstractCollection
{
    /**
     * Throws an exception if the given item is not a valid item for this collection.
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item to validate.
     *
     * @throws \Exception If item is invalid.
     */
    protected function _validateItem($item)
    {
        // Nothing needs to happen if the item is valid.
    }

    /**
     * Determines whether the given item is valid for this collection.
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item to test.
     *
     * @return bool True if the item is valid for this collection; false otherwise.
     */
    protected function _isValidItem($item)
    {
        try {
            $this->_validateItem($item);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Throws an exception if the specified key is not valid for this collection.
     *
     * @since [*next-version*]
     *
     * @param string $key The key to validate.
     *
     * @throws \Exception If key is invalid.
     */
    protected function _validateKey($key)
    {
        // Nothing needs to happen if the item is valid.
    }

    /**
     * Determines whether the given key is valid for this collection.
     *
     * @since [*next-version*]
     *
     * @param string $key The key to validate.
     *
     * @return bool True if the key is valid; otherwise false.
     */
    protected function _isValidKey($key)
    {
        try {
            $this->_validateKey($key);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
