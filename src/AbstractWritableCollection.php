<?php

namespace Dhii\Collection;

/**
 * Basic common functionality for collections.
 *
 * Provides functionality necessary for implementation of {@see WritableCollectionInterface}.
 *
 * @since [*next-version*]
 */
abstract class AbstractWritableCollection extends AbstractReadableCollection
{
    /**
     * Adds items to the collection.
     *
     * The consumer is responsible for clearning the cache afterwards.
     *
     * @see _clearItemCache()
     * @since [*next-version*]
     *
     * @param array|\Traversable $items Items to add.
     *
     * @return AbstractCollection This instance.
     */
    protected function _addItems($items)
    {
        foreach ($items as $_key => $_item) {
            $this->_validateItem($_item);
            $this->_addItem($_item);
        }

        return $this;
    }

    /**
     * Add an item to the collection.
     * The consumer is responsible for clearning the cache afterwards.
     *
     * @see _clearItemCache()
     * @since [*next-version*]
     *
     * @param mixed $item       The item to add.
     * @param bool  $isValidate Whether or not to validate the item that is being added.
     *
     * @return bool True if item successfully added; false if adding failed.
     */
    protected function _addItem($item, $isValidate = true)
    {
        if ($isValidate) {
            $this->_validateItem($item);
        }

        $key = $this->_getItemUniqueKey($item);

        return $this->_arraySet($this->_getItemStorage(), $item, $key);
    }

    /**
     * Sets an item at the specified key in this collection.
     * The consumer is responsible for clearning the cache afterwards.
     *
     * @see _clearItemCache()
     * @since [*next-version*]
     *
     * @param string $key  The key, at which to set the item
     * @param mixed  $item The item to set.
     *
     * @return bool True if item successfully set; false if setting failed.
     */
    protected function _setItem($key, $item)
    {
        return $this->_arraySet($this->_getItemStorage(), $item, $key);
    }

    /**
     * Set the internal items list.
     *
     * The internal list will be replaced with the one given.
     * The consumer is responsible for clearning the cache afterwards.
     *
     * @see _clearItemCache()
     * @since [*next-version*]
     *
     * @param array|\Traversable $items The item list to set.
     *
     * @return AbstractCollection This instance.
     */
    protected function _setItems($items)
    {
        $this->_validateItemList($items);
        $currentItems = $this->_getItemStorage();
        $currentItems = $items;

        return $this;
    }

    /**
     * Get a collection-wide unique key for an item.
     *
     * Determines ultimately whether same items are allowed in collection.
     *
     * It is not guaranteed to be consistent, e.g. running this several
     * times on the same argument will likely produce different results.
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item, for which to get the key.
     *
     * @return string|int A key that is guaranteed to be different from all other keys in this collection.
     */
    protected function _getItemUniqueKey($item)
    {
        return $this->_generateUniqueKey($item);
    }

    /**
     * Generates a key that is guaranteed to be collection-wide unique.
     *
     * @since [*next-version*]
     *
     * @param mixed $item The item, for which to generated the key.
     *
     * @return string The unique key.
     */
    protected function _generateUniqueKey($item)
    {
        $key       = $this->_getItemKey($item);
        $uniqueKey = $key;

        while ($this->_hasItemKey($uniqueKey)) {
            $uniqueKey = implode('-', array($key, $this->_createRandomHash()));
        }

        return $uniqueKey;
    }

    /**
     * Generates a random number.
     *
     * @param int $length The length of the hash to return.
     *
     * @return string A random number of the specified length.
     */
    protected function _createRandomHash($length = 7)
    {
        $hash = $this->_hash(uniqid('', true));
        $hash = substr($hash, 0, $length);

        return $hash;
    }

    /**
     * Set an item at the specified key in the given list.
     *
     * @since [*next-version*]
     *
     * @param mixed[]|\ArrayAccess|MutableCollectionInterface $list The list, for which to set the value.
     * @param mixed                                           $item The item to set for the specified key.
     * @param string                                          $key  The key, for which to set the item.
     *
     * @throws RuntimeException If list is not something that can have a value set.
     *
     * @return bool True if the value has been successfully set; false if setting failed.
     */
    protected function _arraySet(&$list, $item, $key)
    {
        if (is_array($list)) {
            $list[$key] = $item;

            return true;
        }

        if ($list instanceof \ArrayAccess) {
            $list->offsetSet($key, $item);

            return true;
        }

        if ($list instanceof MutableCollectionInterface) {
            return $list->setItem($item, $key);
        }

        throw $this->_createUnexpectedValueException(sprintf(
            'Could not set list item  for key "%1$s": the list is not something that can have an item set', $key));
    }
}
