<?php

namespace Dhii\Collection\FuncTest;

use Dhii\Collection;

/**
 * Tests {@see Collection\AbstractRemovalCapableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractRemovalCapableCollectionTest extends \Xpmock\TestCase
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
        $mock = $this->mock('Dhii\\Collection\\AbstractRemovalCapableCollection')
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

        $this->assertInstanceOf('Dhii\\Collection\\AbstractRemovalCapableCollection', $subject, 'Subject instance is not valid');
    }

    /**
     * Tests whether the subject will correctly determine existence of items.
     *
     * @since [*next-version*]
     */
    public function testRemoveOne()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $data = array('banana', 'orange');
        $reflection->items = $data;
        $this->assertEquals($data, $reflection->_getItems(), 'Subject did not report correct items before removal');
        $reflection->_removeItem('banana');
        $this->assertEquals(array('orange'), array_values($reflection->_getItems()), 'Subject did not report correct items after removal');
        
    }
}
