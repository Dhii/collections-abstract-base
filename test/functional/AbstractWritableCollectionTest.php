<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractWritableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractWritableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractWritableCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractWritableCollection')
                ->new();

        $reflection = $this->reflect($mock);
        $reflection->_construct();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf('Dhii\\Collection\\AbstractWritableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the subject will correctly add new items.
     *
     * @since [*next-version*]
     */
    public function testAddOne()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        // One item - all indicators consistent
        $this->assertEmpty($reflection->items, 'Subject reported non-empty items after creation');
        $item1 = 'banana';
        $reflection->_addItem($item1);
        $this->assertEquals(1, count($reflection->items), 'Subject does not contain correct number of items');
        $this->assertContains($item1, $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertEquals(1, count($reflection->_getItems()), 'Subject does not report correct number of items');
        $this->assertEquals(1, count($reflection->_getCachedItems()), 'Subject does not report correct number of items');
        
        // Adding item but not clearing cache
        $item2 = 'apple';
        $reflection->_addItem($item2);
        $this->assertEquals(2, count($reflection->items), 'Subject does not contain correct number of items');
        $this->assertContains($item1, $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains($item2, $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertEquals(2, count($reflection->_getItems()), 'Subject does not report correct number of items');
        $this->assertEquals(1, count($reflection->_getCachedItems()), 'Subject does not report correct number of items');
        
        // Clearing cache - should report second item now
        $reflection->_clearItemCache();
        $this->assertEquals(2, count($reflection->_getCachedItems()), 'Subject does not report correct number of items');
        
        // Adding same item again - should get added
        $reflection->_addItem($item1);
        $this->assertEquals(3, count($reflection->items), 'Subject does not contain correct number of items');
        $this->assertContains($item1, $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains($item2, $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertEquals(3, count($reflection->_getItems()), 'Subject does not report correct number of items');
        $this->assertEquals(2, count($reflection->_getCachedItems()), 'Subject does not report correct number of items');
        
        // Clearing cache - should report third item now
        $reflection->_clearItemCache();
        $this->assertEquals(3, count($reflection->_getCachedItems()), 'Subject does not report correct number of items');
        
        // Should occur twice
        $item1Occurrences = array_keys($reflection->_getItems(), $item1);
        $this->assertCount(2, $item1Occurrences, 'Item does not occur the correct number of times');
        
        // Should occur once
        $item2Occurrences = array_keys($reflection->_getItems(), $item2);
        $this->assertCount(1, $item2Occurrences, 'Item does not occur the correct number of times');
    }
}
