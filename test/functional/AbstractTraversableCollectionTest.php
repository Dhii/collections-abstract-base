<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractTraversableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractTraversableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractTraversableCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractTraversableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractTraversableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the collection can correctly iterate over its items, using cache.
     *
     * @since [*next-version*]
     */
    public function testIteration()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $data = array('banana', 'orange');
        $reflection->items = $data;
        $index = 0;
        while ($reflection->_valid()) {
            $index++;
            $item = $reflection->_current();
            $this->assertContains($item, $data, 'Iteration did not yield correct items');
            
            $reflection->_next();
        }
        $reflection->_rewind();
        $this->assertEquals(2, $index, 'Iterated for incorrect number of times');
        
        // Testing whether cache works by adding items and iterating again
        $data = array_merge($data, array('one', 'two'));
        $reflection->items = $data;
        $index = 0;
        while ($reflection->_valid()) {
            $index++;
            $item = $reflection->_current();
            $this->assertContains($item, $data, 'Iteration did not yield correct items');
            
            $reflection->_next();
        }
        $reflection->_rewind();
        $this->assertEquals(2, $index, 'Iterated for incorrect number of times after adding items');
        
        // Now clearing cache and iterating again
        $reflection->_clearItemCache();
        $index = 0;
        while ($reflection->_valid()) {
            $index++;
            $item = $reflection->_current();
            $this->assertContains($item, $data, 'Iteration did not yield correct items');
            
            $reflection->_next();
        }
        $reflection->_rewind();
        $this->assertEquals(4, $index, 'Iterated for incorrect number of times after clearing item cache');
    }
}
