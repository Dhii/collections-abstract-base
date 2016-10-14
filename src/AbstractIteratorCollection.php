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
            throw new Exception(sprintf('Not a valid iterator group item'));
        }
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function current()
    {
        $iterator = $this->_current();
        return $iterator->current();
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function valid()
    {
        return parent::valid() && $this->_current()->valid();
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function next()
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
}
