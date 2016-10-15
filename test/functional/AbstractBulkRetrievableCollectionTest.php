<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractBulkRetrievableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractBulkRetrievableCollectionTest extends \Xpmock\TestCase
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
        $mock = $this->mock('Dhii\\Collection\\AbstractBulkRetrievableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractBulkRetrievableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the iterator will correctly retrieve its items.
     *
     * @since [*next-version*]
     */
    public function testItemRetrieval()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->items = array('banana');
        $this->assertEquals(array('banana'), $reflection->_getItems(), 'Subject reported wrong items');
    }
}
