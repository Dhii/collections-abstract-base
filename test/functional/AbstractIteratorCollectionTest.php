<?php

namespace Dhii\Collection\FuncTest;

/**
 * Tests {@see Dhii\Collection\AbstractIteratorCollection}.
 *
 * @since [*next-version*]
 */
class AbstractIteratorCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Dhii\Collection\AbstractIteratorCollection
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\Collection\AbstractIteratorCollection')
                ->_validateItem()
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractIteratorCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether or not the items in internal iterators will get iterated over correctly.
     *
     * @since [*next-version*]
     */
    public function testInnerIteration()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $array1 = array('one' => 'apple', 'two' => 'orange');
        $array2 = array('three' => 'one', 'four' => 'two');
        $data = array(
            new \ArrayIterator($array1),
            new \ArrayIterator($array2)
        );
        $reflection->items = $data;
        $index = 0;
        $innerItems = array();
        while ($reflection->_validInnerItem()) {
            $index++;
            $item = $reflection->_currentInnerItem();
            $innerItems[$reflection->_keyInnerItem()] = $item;

            $reflection->_nextInnerItem();
        }
        $reflection->_rewind();
        $this->assertEquals(array_merge($array1, $array2), $innerItems, 'Iteration did not yield correct result');
    }

    /**
     * Tests whether or not the internal iterators can be iterated over correctly.
     *
     * @since [*next-version*]
     */
    public function testOuterIteration()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $item1 = new \ArrayIterator(array('apple', 'orange'));
        $item2 = new \ArrayIterator(array('one', 'two'));
        $data = array($item1, $item2);
        $reflection->items = $data;
        $index = 0;
        $innerItems = array();
        while ($reflection->_valid()) {
            $index++;
            $item = $reflection->_current();
            $innerItems[$reflection->_key()] = $item;

            $reflection->_next();
        }
        $reflection->_rewind();
        $this->assertEquals($data, $innerItems, 'Iteration did not yield correct result');
    }
}
