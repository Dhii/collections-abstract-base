<?php

namespace Dhii\Collection\FuncTest;

/**
 * Tests {@see Dhii\Collection\AbstractHasher}.
 *
 * @since [*next-version*]
 */
class AbstractHasherTest extends \Xpmock\TestCase
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
        $mock = $this->mock('Dhii\Collection\AbstractHasher')
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

        $this->assertInstanceOf('Dhii\Collection\AbstractHasher', $subject, 'Subject is not a valid hasher.');
    }

    /**
     * Tests whether or not hashing is done right.
     *
     * @since [*next-version*]
     */
    public function testHashing()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $exampleString = 'abcdef123456';
        $stringHash = $reflection->_hash($exampleString);
        $this->assertNotEquals($exampleString, $stringHash, 'String hash is same as string');
        $this->assertInternalType('string', $stringHash, 'String hash is not a string');

        $exampleObject = new \stdClass();
        $exampleObject->myMember = 'qwerty98765';
        $objectHash = $reflection->_hash($exampleObject);
        $this->assertNotEquals($exampleObject, $objectHash, 'Object hash is same as string');
        $this->assertInternalType('string', $objectHash, 'Object hash is not a string');
    }
}
