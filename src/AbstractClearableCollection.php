<?php

namespace Dhii\Collection;

/**
 * Common functionality for collections, the items of which can be cleared.
 * 
 * Provides functionality necessary for implementation of {@see ClearableCollectionInterface}.
 * 
 * @since [*next-version*]
 */
abstract class AbstractClearableCollection extends AbstractHasher
{
    /**
     * Retrieve a reference to the internal items storage.
     * 
     * @since [*next-version*]
     * 
     * @return mixed[]|\Traversable
     */
    abstract protected function &_getItemStorage();

    /**
     * Clears all items stored in this instance.
     * 
     * @see ClearableCollectionInterface::clear()
     * 
     * @since [*next-version*]
     */
    protected function _clearItems()
    {
        $this->_resetItems();
    }
    
    /**
     * Resets the items storage to its initial state.
     * 
     * @since [*next-version*]
     */
    protected function _resetItems()
    {
        $items = &$this->_getItemStorage();
        $items = array();
    }
}
