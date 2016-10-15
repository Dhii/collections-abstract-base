<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractCollection}.
 *
 * @since [*next-version*]
 */
class AbstractCollectionTest extends \Xpmock\TestCase
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
        $mock = $this->mock('Dhii\\Collection\\AbstractCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the subject will correctly determine existence of items.
     *
     * @since [*next-version*]
     */
    public function testHasItem()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->items = array('banana');
        $this->assertTrue($reflection->_hasItem('banana'), 'Subject reported existance of non-existing item');
        $this->assertFalse($reflection->_hasItem('orange'), 'Subject did not report existance of existing item');
        
    }
}
