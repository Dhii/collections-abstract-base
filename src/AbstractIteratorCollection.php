<?php

namespace Dhii\Collection;

/**
 * A collection of iterators.
 *
 * Intended for implementation of {@see \Dhii\Collection\SequentialIteratorInterface}.
 *
 * @since [*next-version*]
 */
abstract class AbstractIteratorCollection extends AbstractIterableCollection
{

    /**
     * @see SequentialIteratorInterface::getIterators()
     *
     * @since [*next-version*]
     */
    protected function _getIterators()
    {
        return $this->_getItems();
    }

    /**
     * Gets the current iterator index.
     *
     * @since [*next-version*]
     *
     * @return int The index of the current iterator.
     */
    protected function _getIteratorIndex()
    {
        return $this->_key();
    }

    /**
     * @see SequentialIteratorInterface::getInnerIterator()
     *
     * @since [*next-version*]
     */
    protected function _getInnerIterator()
    {
        return $this->_current();
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    protected function _validateItem($item)
    {
        if (!($item instanceof \Iterator)) {
            throw $this->_createRuntimeException(sprintf('Not a valid iterator group item'));
        }
    }
    
    protected function _nextInnerItem()
    {
        // Advance in the current iterator
        $iterator = $this->_current();
        $iterator->next();
        // If next item is valid, good
        if ($iterator->valid()) {
            return;
        }
        // If next item is not valid, advance iterator
        $this->_next();
        // Rewind next iterator
        if ($this->valid() && ($iterator = $this->_current()) instanceof \Iterable) {
            $iterator->rewind();
        }
    }
    
    protected function _currentInnerItem()
    {
        $iterator = $this->_current();
        
        return $iterator->current();
    }
    
    protected function _validInnerItem()
    {
        return parent::valid() && $this->_current()->valid();
    }
    
    protected function _keyInnerItem()
    {
        $iterator = $this->_current();
        
        return $iterator->key();
    }
}
