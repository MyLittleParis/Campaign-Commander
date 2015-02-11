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

        $xml = file_get_contents($mockFile);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $return = $doc->getElementsByTagName('return')->item(0)->nodeValue;

        return $return;

    }

  
}
