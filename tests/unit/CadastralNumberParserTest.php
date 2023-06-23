<?php


namespace tests\unit;

use app\components\ApiComponent;
use \UnitTester;

class CadastralNumberParserTest extends \Codeception\Test\Unit
{
    private $apiComponent;
    protected UnitTester $tester;

    protected function _before()
    {
        $this->apiComponent = new ApiComponent();
    }

    //php vendor/bin/codecept run unit CadastralNumberParserTest
    public function testSomeFeature()
    {
        $variables = [
            "77:01:1234567:890, 78:02:9876543:210, 79:03:5678901:543",
            "77:01:1234567:890 78:02:9876543:210 79:03:5678901:543",
            "77:01:1234567:890,        78:02:9876543:210,           79:03:5678901:543",
            "77:01:1234567:890,78:02:9876543:210,79:03:5678901:543",
        ];

        $expectedNumbers = [
            "77:01:1234567:890",
            "78:02:9876543:210",
            "79:03:5678901:543"
        ];

        foreach ($variables as $resolve) {
            $this->assertEquals($expectedNumbers, $this->apiComponent->parseCn($resolve));
        }
    }
}
