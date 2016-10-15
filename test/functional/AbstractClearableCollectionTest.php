<?php

namespace Dhii\Collection\FuncTest;

/**
 * Tests {@see Dhii\Collection\AbstractClearableCollection}.
 *
 * @since [*next-version*]
 */
class AbstractClearableCollectionTest extends \Xpmock\TestCase
{
    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Dhii\Collection\AbstractClearableCollection
     */
    public function createInstance()
    { 
        $mock = $this->mock('Dhii\Collection\AbstractClearableCollection')
                ->_getItemStorage(function & () {
                    static $storage = 'nothing';
                    
                    return $storage;
                })
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

        $this->assertInstanceOf('Dhii\Collection\AbstractClearableCollection', $subject, 'Subject is not a valid hasher.');
    }

    /**
     * Tests whether the test subject will correctly reset inner item storage.
     *
     * @since [*next-version*]
     */
    protected function _testResetItems()
    {
        $this->markTestSkipped('There does not appear to be a way of acquiring a reference returned by a reflection method');
        
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $reflection->_resetItems();
        $this->assertEquals(array(), $reflection->_getItemStorage(), 'Item storage retrieved by reference was not updated with new value');
    }
}
