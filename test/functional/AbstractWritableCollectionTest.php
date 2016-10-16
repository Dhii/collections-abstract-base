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
                ->_validateItem(function($item) {
                    if (!is_scalar($item)) {
                        throw new \RuntimeException('The value must be scalar');
                    }
                })
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

    /**
     * Tests whether the subject will correctly add new items.
     *
     * @since [*next-version*]
     */
    public function testAddMany()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        // One set of items - all indicators consistent
        $this->assertEmpty($reflection->items, 'Subject reported non-empty items after creation');
        $items1 = array('banana', 'orange');
        $reflection->_addItems($items1);
        $this->assertCount(2, $reflection->items, 'Subject does not contain correct number of items');
        $this->assertContains('banana', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains('orange', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertCount(2, $reflection->_getItems(), 'Subject does not report correct number of items');
        $this->assertCount(2, $reflection->_getCachedItems(), 'Subject does not report correct number of items');

        // Adding items but not clearing cache
        $items2 = array('apple', 'pear');
        $reflection->_addItems($items2);
        $this->assertCount(4, $reflection->items, 'Subject does not contain correct number of items');
        $this->assertContains('banana', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains('orange', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains('apple', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertContains('pear', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertCount(4, $reflection->items, 'Subject does not contain correct number of items');
        $this->assertContains('banana', $reflection->_getItems(), 'Subect does not report containing required item');
        $this->assertCount(4, $reflection->_getItems(), 'Subject does not report correct number of items');
        $this->assertCount(2, $reflection->_getCachedItems(), 'Subject does not report correct number of items');

        // Clearing cache - should report second set of items now
        $reflection->_clearItemCache();
        $this->assertCount(4, $reflection->_getCachedItems(), 'Subject does not report correct number of items');

        // Adding same items again - should get added
        $reflection->_addItems($items1);
        $this->assertCount(6, $reflection->items, 'Subject does not contain correct number of items');
        $this->assertCount(6, $reflection->_getItems(), 'Subject does not report correct number of items');
        $this->assertCount(4, $reflection->_getCachedItems(), 'Subject does not report correct number of items');

        // Clearing cache - should report third item now
        $reflection->_clearItemCache();
        $this->assertCount(6, $reflection->_getCachedItems(), 'Subject does not report correct number of items');

        // Should occur twice
        $item1_0Occurrences = array_keys($reflection->_getItems(), $items1[0]);
        $this->assertCount(2, $item1_0Occurrences, 'Item does not occur the correct number of times');
        $item1_1Occurrences = array_keys($reflection->_getItems(), $items1[1]);
        $this->assertCount(2, $item1_1Occurrences, 'Item does not occur the correct number of times');

        // Should occur once
        $item2_0Occurrences = array_keys($reflection->_getItems(), $items2[0]);
        $this->assertCount(1, $item2_0Occurrences, 'Item does not occur the correct number of times');
        $item2_1Occurrences = array_keys($reflection->_getItems(), $items2[1]);
        $this->assertCount(1, $item2_1Occurrences, 'Item does not occur the correct number of times');
    }

    /**
     * Tests whether a single item will fail to get added due to being invalid.
     *
     * @expectedException Exception
     * @expectedExceptionMessage must be scalar
     *
     * @since [*next-version*]
     */
    public function testAddOneValidationFails()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $data = new \stdClass();
        $reflection->_addItem($data);
    }
}
