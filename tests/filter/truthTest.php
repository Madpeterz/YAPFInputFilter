<?php

namespace YAPFtest;

use PHPUnit\Framework\TestCase;
use YAPF\InputFilter\InputFilter;

class truthTest extends TestCase
{
    public function test_isNot()
    {
        $_GET["testing"] = "asdasd";
        $_POST["magic"] = "wow";

        $input = new InputFilter();
        $reply = $input->get("testing")->isNot("Peter")->asString();
        $this->assertSame("asdasd", $reply, $input->getWhyFailed());

        $reply = $input->get("testing")->isNot("asdasd")->asString();
        $this->assertSame(null, $reply, "Expected reply to be null");

        $reply = $input->post("magic")->isNot("Tree")->asString();
        $this->assertSame("wow", $reply, $input->getWhyFailed());

        $reply = $input->post("magic")->isNot("wow")->asString();
        $this->assertSame(null, $reply, "Expected reply to be null");

        $_GET["testing"] = 1234;
        $_POST["magic"] = 55;

        $reply = $input->get("testing")->isNot(78)->asInt();
        $this->assertSame(1234, $reply, $input->getWhyFailed());

        $reply = $input->get("testing")->isNot(1234)->asInt();
        $this->assertSame(null, $reply, "Expected reply to be null");

        $reply = $input->post("magic")->isNot(5050)->asInt();
        $this->assertSame(55, $reply, $input->getWhyFailed());

        $reply = $input->post("magic")->isNot(55)->asInt();
        $this->assertSame(null, $reply, "Expected reply to be null");


        $_GET["testing"] = 75.8453;
        $_POST["magic"] = 99.244564;

        $reply = $input->get("testing")->isNot(11.65)->asFloat();
        $this->assertSame(75.8453, $reply, $input->getWhyFailed());

        $reply = $input->get("testing")->isNot(75.84)->asFloat();
        $this->assertSame(null, $reply, "Expected reply to be null");

        $reply = $input->post("magic")->isNot(1545.545)->asFloat();
        $this->assertSame(99.244564, $reply, $input->getWhyFailed());

        $reply = $input->post("magic")->isNot(99.24)->asFloat();
        $this->assertSame(null, $reply, "Expected reply to be null");

        $_GET["testing"] = [23,"adasd",232.534332];
        $_POST["magic"] = ["magic" => "man", "Hulk" => 2423, "Lost" => "Boys"];

        $reply = $input->get("testing")->isNot([55,"wool",234.232])->asArray();
        $this->assertSame([23,"adasd",232.534332], $reply, $input->getWhyFailed());

        $reply = $input->get("testing")->isNot(["adasd",23,232.534332])->asArray();
        $this->assertSame(null, $reply, "Expected reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isNot([23,"adasd",232.534332])->asArray();
        $this->assertSame(["magic" => "man", "Hulk" => 2423, "Lost" => "Boys"], $reply, $input->getWhyFailed());

        $reply = $input->post("magic")->isNot(["Hulk" => 2423, "magic" => "man", "Lost" => "Boys"])->asArray();
        $this->assertSame(null, $reply, "Expected reply to be null ".$input->getWhyFailed());
    }

    public function test_isJson()
    {
        $_GET["testing"] = json_encode(["red"=>"wolf",42=>"lost","up" => "down"]);
        $_GET["testing2"] = "asdasd1234qf";
        $_POST["magic"] = json_encode(["users"=>[],"votes"=>["up"=>1]]);
        $_POST["magic2"] = "<xml><red>Wolf</red><42>lost</42><up>down</up></xml>";
        
        $input = new InputFilter();
        $reply = $input->get("testing")->isJson()->asArray();
        $this->assertSame(["red"=>"wolf",42=>"lost","up" => "down"], $reply, $input->getWhyFailed());

        $reply = $input->get("testing2")->isJson()->asArray();
        $this->assertSame(null, $reply, "Expected reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isJson()->asArray();
        $this->assertSame(["users"=>[],"votes"=>["up"=>1]], $reply, $input->getWhyFailed());

        $reply = $input->post("magic2")->isJson()->asArray();
        $this->assertSame(null, $reply, "Expected reply to be null ".$input->getWhyFailed());
    }

    public function test_isUuid()
    {
        $_GET["testing"] = "01234567-89ab-cdef-0123-456789abcdef";
        $_GET["testing2"] = "0123456Z-89ab-cdef-0123-456789abcdef";
        $_POST["magic"] = "01234567-89ab-cdef-0123-456789abcdef";
        $_POST["magic2"] = "0123456Z-89ab-cdef-0123-456789abcdef";
        $input = new InputFilter();
        $reply = $input->get("testing")->isUuid()->asString();
        $this->assertSame($reply, "01234567-89ab-cdef-0123-456789abcdef", $input->getWhyFailed());

        $reply = $input->get("testing2")->isUuid()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isUuid()->asString();
        $this->assertSame($reply, "01234567-89ab-cdef-0123-456789abcdef", $input->getWhyFailed());

        $reply = $input->post("magic2")->isUuid()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isUrl()
    {
        $_GET["testing"] = "http://google.com";
        $_GET["testing2"] = "uri://lost.com";
        $_POST["magic"] = "https://dev.google.dev";
        $_POST["magic2"] = "https://reddit";
        $input = new InputFilter();
        $reply = $input->get("testing")->isUrl()->asString();
        $this->assertSame($reply, "http://google.com", $input->getWhyFailed());

        $reply = $input->get("testing2")->isUrl()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isUrl(true)->asString();
        $this->assertSame($reply, "https://dev.google.dev", $input->getWhyFailed());

        $reply = $input->post("magic2")->isUrl(true)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isHexColor()
    {
        $_GET["testing"] = "#FFAAAA";
        $_GET["testing2"] = "#ZZ55FG";
        $_POST["magic"] = "000";
        $_POST["magic2"] = "MAG";
        $input = new InputFilter();
        $reply = $input->get("testing")->isHexColor()->asString();
        $this->assertSame($reply, "#FFAAAA", $input->getWhyFailed());

        $reply = $input->get("testing2")->isHexColor()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isHexColor()->asString();
        $this->assertSame($reply, "000", $input->getWhyFailed());

        $reply = $input->post("magic2")->isHexColor()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isRgbVector3()
    {
        $_GET["testing"] = "<123,123,123>";
        $_GET["testing2"] = "<700,500,400>";
        $_POST["magic"] = "<125,0,0>";
        $_POST["magic2"] = "<125,0,0,0>";
        $input = new InputFilter();
        $reply = $input->get("testing")->isRgbVector3()->asString();
        $this->assertSame($reply, "<123,123,123>", $input->getWhyFailed());

        $reply = $input->get("testing2")->isRgbVector3()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isRgbVector3()->asString();
        $this->assertSame($reply, "<125,0,0>", $input->getWhyFailed());

        $reply = $input->post("magic2")->isRgbVector3()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isEmail()
    {
        $_GET["testing"] = "testing@mail.google.com";
        $_GET["testing2"] = "testing/¤youtube@studio.com";
        $_POST["magic"] = "contact@support.kp.net";
        $_POST["magic2"] = "+4400000000000";
        $input = new InputFilter();
        $reply = $input->get("testing")->isEmail()->asString();
        $this->assertSame($reply, "testing@mail.google.com", $input->getWhyFailed());

        $reply = $input->get("testing2")->isEmail()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isEmail()->asString();
        $this->assertSame($reply, "contact@support.kp.net", $input->getWhyFailed());

        $reply = $input->post("magic2")->isEmail()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isVector3()
    {
        $_GET["testing"] = "<123.213,35345.635,3545.4564>";
        $_GET["testing2"] = "123.213,35345.635,3545.4564";
        $_POST["magic"] = "123.213,35345.635,3545.4564";
        $_POST["magic2"] = "what";
        $input = new InputFilter();
        $reply = $input->get("testing")->isVector3()->asString();
        $this->assertSame($reply, "<123.213,35345.635,3545.4564>", $input->getWhyFailed());

        $reply = $input->get("testing2")->isVector3()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isVector3(false)->asString();
        $this->assertSame($reply, "123.213,35345.635,3545.4564", $input->getWhyFailed());

        $reply = $input->post("magic2")->isVector3(false)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());
    }

    public function test_isDate()
    {
        $_GET["testing"] = "12/25/1999";
        $_GET["testing2"] = "15/05/0001";
        $_POST["magic"] = "5/4/2010";
        $_POST["magic2"] = "-1/55/3050";
        $input = new InputFilter();
        $input->get("testing")->isDate();
        $reply = $input->asString();
        $this->assertSame($reply, "12/25/1999", $input->getWhyFailed());
        $reply = $input->asHumanReadable();
        $this->assertSame($reply, "Saturday 25th of December 1999", $input->getWhyFailed());
        $reply = $input->asInt();
        $this->assertSame($reply, 946080000, $input->getWhyFailed());

        $reply = $input->get("testing2")->isDate()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());

        $reply = $input->post("magic")->isDate()->asString();
        $this->assertSame($reply, "5/4/2010", $input->getWhyFailed());
        $reply = $input->asHumanReadable();
        $this->assertSame($reply, "Tuesday 4th of May 2010", $input->getWhyFailed());
        $reply = $input->asInt();
        $this->assertSame($reply, 1272927600, $input->getWhyFailed());


        $reply = $input->post("magic2")->isDate()->asString();
        $this->assertSame($reply, null, "Expected the reply to be null ".$input->getWhyFailed());


    }
}
