<?php

namespace Dhii\Collection\FuncTest;

/**
 * Tests {@see Dhii\Collection\AbstractIterableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractIterableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Dhii\Collection\AbstractHasher
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\Collection\AbstractIterableCollection')
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

        $this->assertInstanceOf('Dhii\Collection\CollectionInterface', $subject, 'Subject is not a valid collection.');
        $this->assertInstanceOf('Dhii\Collection\AbstractIterableCollection', $subject, 'Subject is not a valid iterable collection.');
        $this->assertInstanceOf('Iterator', $subject, 'Subject is not a valid iterator.');
    }

    /**
     * Tests whether or not this collection is actually iterable.
     *
     * @since [*next-version*]
     */
    public function testIsIterable()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items = array(
            'apple',
            'orange',
            'banana'
        );
        $reflection->items = $items;

        $i = 0;
        foreach ($subject as $_key => $_item) {
            $this->assertSame($items[$i], $_item);
            $i++;
        }
    }

    /**
     * Tests whether or not this collection is actually iterable when the
     * items are a {@see \Traversable} internally.
     *
     * @since [*next-version*]
     */
    public function testIsIterableTraversable()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items = array(
            'apple',
            'orange',
            'banana'
        );
        $reflection->items = new \ArrayIterator($items);

        $i = 0;
        foreach ($subject as $_item) {
            $this->assertSame($items[$i], $_item);
            $i++;
        }
    }

    /**
     * Tests whether or not this collection can count its items.
     *
     * @since [*next-version*]
     */
    public function testIsCountable()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items = array(
            'apple',
            'orange',
            'banana'
        );
        $reflection->items = $items;

        $this->assertSame(count($items), $reflection->_count(), 'Item count is incorrect');
    }

    /**
     * Tests whether or not this collection can count its items when they are
     * a {@see \Traversable} internally.
     *
     * @since [*next-version*]
     */
    public function testIsCountableTraversable()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $items = array(
            'apple',
            'orange',
            'banana'
        );
        $reflection->items = new \IteratorIterator(new \ArrayIterator($items));

        $this->assertSame(count($items), $reflection->_count(), 'Item count is incorrect');
    }
}
