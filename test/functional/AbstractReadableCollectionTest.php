<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractReadableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractReadableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractReadableCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractReadableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractReadableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the subject will correctly determine existence of items.
     *
     * @since [*next-version*]
     */
    public function testGetItem()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $key1 = 'my_fruit';
        $item1 = 'banana';
        $reflection->items = array($key1 => $item1);
        $this->assertEquals($item1, $reflection->_getItem($key1), 'Subject did not retrieve correct item');
        $this->assertNull($reflection->_getItem('other'), 'Subject retrieved non-existing item');
        
        $key2 = 'my_number';
        $item2 = 'one';
        $reflection->items = array_merge($reflection->items, array($key2 => $item2));
        $this->assertNull($reflection->_getItem($key2), 'Subject retrieved non-existing item after update');
        
        $reflection->_clearItemCache();
        $this->assertEquals($item2, $reflection->_getItem($key2), 'Subject did not retrieve correct item after cache cleared');
    }
}
