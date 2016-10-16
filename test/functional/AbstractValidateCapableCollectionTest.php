<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractValidateCapableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractValidateCapableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Collection\AbstractValidateCapableCollection The new test subject instance.
     */
    public function createInstance()
    {
        $mock = $this->mock('Dhii\\Collection\\AbstractValidateCapableCollection')
                ->_validateItem(function($item) {
                    if (!is_string($item)) {
                        throw new \Exception('Item must be a string');
                    }
                })
                ->_validateKey(function($key) {
                    if (!is_string($key)) {
                        throw new \Exception('Key must be a string');
                    }
                })
                ->_validateItemList(function($items) {
                    if (!is_array($items)) {
                        throw new \Exception('Item list must be an array');
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractValidateCapableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the subject will correctly determine the validity of an item.
     *
     * @since [*next-version*]
     */
    public function testItemValidation()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $this->assertTrue($reflection->_isValidItem('banana'), 'Subject reported a valid item as invalid');
        $this->assertFalse($reflection->_isValidItem(123), 'Subject did not report an invalid item as invalid');
    }

    /**
     * Tests whether the subject will correctly determine the validity of a key.
     *
     * @since [*next-version*]
     */
    public function testKeyValidation()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $this->assertTrue($reflection->_isValidKey('my_key'), 'Subject reported a valid key as invalid');
        $this->assertFalse($reflection->_isValidKey(123), 'Subject did not report an invalid key as invalid');
    }

    /**
     * Tests whether the subject will correctly determine the validity of an item storage.
     *
     * @since [*next-version*]
     */
    public function testItemListValidation()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $this->assertTrue($reflection->_isValidItemList(array()), 'Subject reported a valid item list as invalid');
        $this->assertFalse($reflection->_isValidItemList(new \ArrayIterator(array())), 'Subject did not report an invalid item list as invalid');
    }
}
