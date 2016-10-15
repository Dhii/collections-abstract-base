<?php

namespace Dhii\Collection;

/**
 * Basic common functionality for collections.
 * 
 * Provides functionality necessary for implementation of {@see CollectionInterface}.
 * 
 * @since [*next-version*]
 */
class AbstractCollection extends AbstractClearableCollection
{
    protected $items;
    
    /**
     * Parameter-less constructor.
     *
     * The actual constructor MUST call this method.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
        $this->_resetItems();
    }
    
    /**
     * @inheritdoc
     * 
     * @since [*next-version*]
     */
    protected function &_getItemStorage()
    {
        return $this->items;
    }
    
    /**
     * Retrieves unmodified internal items, by value.
     * 
     * @since [*next-version*]
     * 
     * @return mixed[]|\Traversable
     */
    protected function _getRawItems()
    {
        return $this->_getItemStorage();
    }

    /**
     * Checks whether the given item exists in this collection.
     * 
     * @see CollectionInterface::contains()
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item to check for.
     *
     * @return bool True if the given item exists in this collection; false otherwise.
     */
    protected function _hasItem($item)
    {
        return $this->_findItem($item, true) !== false;
    }

    /**
     * Get the index, at which an item exists in this collection.
     *
     * @since [*next-version*]
     *
     * @param mixed $item   The item to find.
     * @param bool  $strict Whether or not the type must also match.
     *
     * @return int|string|false The key, at which the item exists in this collection, if found;
     *                          false otherwise.
     */
    public function _findItem($item, $strict = false)
    {
        return $this->_arraySearch($this->_getItemStorage(), $item, $strict);
    }

    /**
     * Get the key of an item to use for consistency checks.
     *
     * @since [*next-version*]
     *
     * @param mixed $item Get the key of an item.
     *
     * @return string|int The key of an item.
     */
    protected function _getItemKey($item)
    {
        return $this->_hash($item);
    }

    /**
     * Search a list for a value.
     *
     * @since [*next-version*]
     *
     * @param AbstractCollection|array|\Traversable $array  The list to search.
     * @param mixed                                 $value  The value to search for.
     * @param bool                                  $strict Whether the type must also match.
     *
     * @return int|string|bool The key, at which the value exists in the list, if found;
     *                         false otherwise.
     */
    protected function _arraySearch(&$array, $value, $strict = false)
    {
        // Regular array matching
        if (is_array($array)) {
            return array_search($value, $array, $strict);
        }
        // Using familiar interface
        if ($array instanceof self) {
            return $array->_findItem($value, $strict);
        }
        // Last resort - iterate and compare
        if ($array instanceof \Traversable) {
            foreach ($array as $_idx => $_value) {
                if ($strict && $value === $_value) {
                    return $_idx;
                }

                if (!$strict && $value == $_value) {
                    return $_idx;
                }
            }

            return false;
        }

        throw $this->_createRuntimeException('Could not search list: the list is not something that can be searched');
    }
    
    /**
     * Creates a new runtime exception.
     * 
     * @since [*next-version*]
     * 
     * @param string $message The message of the exception.
     * @param int $code The exception code.
     * @param \Exception $previous A previous exception, if any.
     * 
     * @return \RuntimeException
     */
    protected function _createRuntimeException($message, $code = 0, $previous = null)
    {
        return new \RuntimeException($message, $code, $previous);
    }
    
    /**
     * Creates a new unexpected value exception.
     * 
     * @since [*next-version*]
     * 
     * @param string $message The message of the exception.
     * @param int $code The exception code.
     * @param \Exception $previous A previous exception, if any.
     * 
     * @return \UnexpectedValueException
     */
    protected function _createUnexpectedValueException($message, $code = 0, $previous = null)
    {
        return new \UnexpectedValueException($message, $code, $previous);
    }
}
