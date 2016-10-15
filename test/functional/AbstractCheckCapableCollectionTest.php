<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractCheckCapableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractCheckCapableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractCheckCapableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractCheckCapableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the iterator will correctly determine the existence of items by key.
     *
     * @since [*next-version*]
     */
    public function testHasItemKey()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->items = array('my_fruit' => 'banana');
        $this->assertTrue($reflection->_hasItemKey('my_fruit'), 'Subject reported existance of non-existing key');
        $this->assertFalse($reflection->_hasItemKey('other'), 'Subject did not report existance of existing key');
    }
}
