<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractCollectionCollection}.
 *
 * @since [*next-version*]
 */
class AbstractCollectionCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractCollectionCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractCollectionCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractCollectionCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the iterator will iterate over items in inner iterators correctly.
     *
     * @since [*next-version*]
     */
    public function testSequentialIteration()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items1 = array('apple', 'banana');
        $reflection->_addItem(new \ArrayIterator($items1));
        $items2 = array('one', 'two');
        $reflection->_addItem(new \ArrayIterator($items2));

        $expected = array_merge($items1, $items2);
        $allItems = iterator_to_array($subject, false);
        $this->assertEquals($expected, $allItems, 'Iterating over all items did not produce correct result');
    }

    /**
     * Tests whether the iterator will iterate over inner iterators correctly.
     *
     * @since [*next-version*]
     */
    public function testInnerIteration()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items1 = array('apple', 'banana');
        $items1 = new \ArrayIterator($items1);
        $reflection->_addItem($items1);
        $items2 = array('one', 'two');
        $items2 = new \ArrayIterator($items2);
        $reflection->_addItem($items2);

        $expected = array($items1, $items2);
        $allItems = $reflection->_getIterators();
        $this->assertSame($expected, $allItems, 'Iterating over inner iterators did not produce correct result');
    }
}
