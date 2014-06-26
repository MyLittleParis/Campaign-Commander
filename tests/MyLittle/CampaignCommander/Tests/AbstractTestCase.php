<?php

namespace MyLittle\CampaignCommander\Tests;

/**
 * Abstract test case
 *
 * @author mylittleparis
 */
class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * get the .xml file mock
     *
     * @param type $mockName
     *
     * @return type
     *
     * @throws \InvalidArgumentException
     */
    protected function getXMLFileMock($mockName)
    {
        $mockFile = __DIR__.'/Fixtures/'.$mockName;

        if (!is_file($mockFile) || !is_readable($mockFile)) {
            throw new \InvalidArgumentException("Mock '$mockFile' could not be found.");
        }

        return file_get_contents($mockFile);
    }
}
