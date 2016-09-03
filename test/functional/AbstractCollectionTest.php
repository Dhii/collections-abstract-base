<?php

namespace Dhii\Collection\FuncTest;

/**
 * Tests {@see Dhii\Collection\AbstractCollection}.
 *
 * @since [*next-version*]
 */
class AbstractCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Dhii\Collection\AbstractCollection
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\Collection\AbstractCollection')
                ->_validateItem(function($item) {
                    if ($item instanceof \stdClass) {
                        throw new \Exception('Invalid item');
                    }
                })
                ->new();

        return $mock;
    }

    /**
     * Tests whether a correct instance of a descendant can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf('Dhii\Collection\CollectionInterface', $subject, 'Subject is not a valid collection.');
        $this->assertInstanceOf('Dhii\Collection\AbstractCollection', $subject, 'Subject is not a valid abstract collection.');
    }

    /**
     * Tests whether the collection retrieves correct information.
     *
     * @since [*next-version*]
     */
    public function testItemsRetrieval()
    {
        $subject = $this->createInstance();

        $reflection = $this->reflect($subject);
        $items = array(
            'apple',
            'banana',
            'orange'
        );
        $reflection->items = $items;

        // Has all items
        $this->assertCount(count($items), $subject->getItems(), 'Wrong item count');
        foreach ($items as $_item) {
            $this->assertContains($_item, $subject->getItems(), 'Collection item set does not contain required item');
        }

        // Thinks has all items
        foreach ($items as $_item) {
            $this->assertTrue($reflection->_hasItem($_item), 'Collection does not contain required item');
        }

        // Has item with key
        $this->assertTrue($reflection->_hasItemKey(2), 'Collection does not contain required key');
        // Retrieve item by key
        $this->assertEquals('banana', $reflection->_getItem(1), 'Collection does not contain required item');
    }

    /**
     * Tests whether the collection retrieves correct information from a {@see \Traversable}.
     *
     * @since [*next-version*]
     */
    public function testItemsRetrievalIterator()
    {
        $subject = $this->createInstance();

        $reflection = $this->reflect($subject);
        $items = array(
            'apple',
            'banana',
            'orange'
        );
        $reflection->items = new \ArrayIterator($items);

        // Has all items
        $this->assertCount(count($items), $subject->getItems(), 'Wrong item count');
        foreach ($items as $_item) {
            $this->assertContains($_item, $subject->getItems(), 'Collection item set does not contain required item');
        }

        // Thinks has all items
        foreach ($items as $_item) {
            $this->assertTrue($reflection->_hasItem($_item), 'Collection does not contain required item');
        }

        // Has item with key
        $this->assertTrue($reflection->_hasItemKey(2), 'Collection does not contain required key');
        // Retrieve item by key
        $this->assertEquals('banana', $reflection->_getItem(1), 'Collection does not contain required item');
    }

    /**
     * Tests whether the collection maniulates items correctly.
     *
     * @since [*next-version*]
     */
    public function testItemsManipulation()
    {
        $subject = $this->createInstance();

        $reflection = $this->reflect($subject);
        $items = array(
            'apple',
            'banana',
            'orange'
        );
        $reflection->_addItems($items);

        // Setting
        $newItem = 'strawberry';
        $this->assertEquals('banana', $reflection->items[1], 'The original item could not be retrieved');
        $reflection->_setItem(1, $newItem);
        $this->assertEquals($newItem, $reflection->items[1], 'The set item could not be retrieved');

        // Removal
        $oldItem = 'orange';
        $reflection->_removeItem($oldItem);
        $this->assertNotContains($oldItem, $reflection->items, 'The collection contains a removed item');
    }

    /**
     * Tests whether the collection maniulates items correctly if they are
     * an instance of {@see \ArrayAccess} internally.
     *
     * @since [*next-version*]
     */
    public function testItemsManipulationArrayAccess()
    {
        $subject = $this->createInstance();

        $reflection = $this->reflect($subject);
        $items = array(
            'apple',
            'banana',
            'orange'
        );
        $reflection->_setItems(new \ArrayObject($items));

        // Setting
        $newItem = 'strawberry';
        $this->assertEquals('banana', $reflection->_getItem(1), 'The original item could not be retrieved');
        $reflection->_setItem(1, $newItem);
        $this->assertEquals($newItem, $reflection->_getItem(1), 'The set item could not be retrieved');

        // Removal
        $oldItem = 'orange';
        $reflection->_removeItem($oldItem);
        $this->assertNotContains($oldItem, $reflection->getItems(), 'The collection contains a removed item');
    }

    /**
     * Tests whether validation is working correctly.
     *
     * @since [*next-version*]
     */
    public function testItemValidation()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $this->assertTrue($reflection->_isValidItem(123123), 'Incorrect validation of valid item');
        $this->assertFalse($reflection->_isValidItem(new \stdClass()), 'Incorrect validation of invalid item');
    }

    /**
     * Tests whether removal operation on a bogus item list fails correctly.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Could not check
     * @since [*next-version*]
     */
    public function testBogusListItemCheck()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->items = 123;

        $reflection->_removeItem('asd');
    }
}
