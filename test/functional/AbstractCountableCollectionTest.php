<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractCountableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractCountableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractCountableCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractCountableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractCountableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the collection can correctly count its items.
     *
     * @since [*next-version*]
     */
    public function testCount()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->items = array('banana', 'orange');
        $this->assertEquals(2, $reflection->_count(), 'Subject reported incorrect item count');
        // Adding items, but cache remains same
        $reflection->items = array_merge($reflection->items, array('one', 'two'));
        $this->assertEquals(2, $reflection->_count(), 'Subject did not report correct item count after update');
        // Now after cache cleared
        $reflection->_clearItemCache();
        $this->assertEquals(4, $reflection->_count(), 'Subject did not report correct item count after clearing cache');
    }
}
