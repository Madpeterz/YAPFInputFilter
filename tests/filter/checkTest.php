<?php

namespace YAPFtest;

use PHPUnit\Framework\TestCase;
use YAPF\InputFilter\InputFilter;

class checkTest extends TestCase
{
    public function test_StartsWith()
    {
        $_GET["testing"] = "asdasd";
        $_POST["magic"] = "wow";
        $input = new InputFilter();
        $reply = $input->get("testing")->checkStartsWith("asd")->asString();
        $this->assertSame($reply, "asdasd", $input->getWhyFailed());

        $reply = $input->get("testing")->checkStartsWith("magic")->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkStartsWith("w")->asString();
        $this->assertSame($reply, "wow", $input->getWhyFailed());

        $reply = $input->post("magic")->checkStartsWith("what")->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_EndsWith()
    {
        $_GET["testing"] = "this is the time";
        $_POST["magic"] = "what a life";
        $input = new InputFilter();
        $reply = $input->get("testing")->checkEndsWith("ime")->asString();
        $this->assertSame($reply, "this is the time", $input->getWhyFailed());

        $reply = $input->get("testing")->checkEndsWith("the")->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkEndsWith("fe")->asString();
        $this->assertSame($reply, "what a life", $input->getWhyFailed());

        $reply = $input->post("magic")->checkEndsWith("pokemon")->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_InRange()
    {
        $_GET["testing"] = 44;
        $_POST["magic"] = 123;
        $input = new InputFilter();
        $reply = $input->get("testing")->checkInRange(30,50)->asInt();
        $this->assertSame($reply, 44, $input->getWhyFailed());

        $reply = $input->get("testing")->checkInRange(71,90)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkInRange(100,150)->asInt();
        $this->assertSame($reply, 123, $input->getWhyFailed());

        $reply = $input->post("magic")->checkInRange(30,60)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_GrtThanEq()
    {
        $_GET["testing"] = 44;
        $_POST["magic"] = 123;
        $input = new InputFilter();
        $reply = $input->get("testing")->checkGrtThanEq(44)->asInt();
        $this->assertSame($reply, 44, $input->getWhyFailed());

        $reply = $input->get("testing")->checkGrtThanEq(55)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkGrtThanEq(15)->asInt();
        $this->assertSame($reply, 123, $input->getWhyFailed());

        $reply = $input->post("magic")->checkGrtThanEq(300)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_LessThanEq()
    {
        $_GET["testing"] = 44;
        $_POST["magic"] = 123;
        $input = new InputFilter();
        $reply = $input->get("testing")->checkLessThanEq(125)->asInt();
        $this->assertSame($reply, 44, $input->getWhyFailed());

        $reply = $input->get("testing")->checkLessThanEq(15)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkLessThanEq(200)->asInt();
        $this->assertSame($reply, 123, $input->getWhyFailed());

        $reply = $input->post("magic")->checkLessThanEq(50)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_MatchRegex()
    {
        $_GET["testing"] = "hello_world";
        $_POST["magic"] = "do_the_thing";
        $regexMatchs = "/^[a-z0-9_]*$/"; // lowercase, 0-9 or _
        $regexMatchsMiss = "/^[_]*$/"; // _ only
        $input = new InputFilter();
        $reply = $input->get("testing")->checkMatchRegex($regexMatchs)->asString();
        $this->assertSame($reply, "hello_world", $input->getWhyFailed());

        $reply = $input->get("testing")->checkMatchRegex($regexMatchsMiss)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkMatchRegex($regexMatchs)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->post("magic")->checkMatchRegex($regexMatchsMiss)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_StringLength()
    {
        $_GET["testing"] = "hello_world";
        $_POST["magic"] = "do_the_thing";

        $input = new InputFilter();
        $reply = $input->get("testing")->checkStringLength(5,30)->asString();
        $this->assertSame($reply, "hello_world", $input->getWhyFailed());

        $reply = $input->get("testing")->checkStringLength(1,3)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkStringLength(1,55)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->post("magic")->checkStringLength(25,30)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_StringLengthMin()
    {
        $_GET["testing"] = "hello_world";
        $_POST["magic"] = "do_the_thing";

        $input = new InputFilter();
        $reply = $input->get("testing")->checkStringLengthMin(5)->asString();
        $this->assertSame($reply, "hello_world", $input->getWhyFailed());

        $reply = $input->get("testing")->checkStringLengthMin(55)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkStringLengthMin(6)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->post("magic")->checkStringLengthMin(80)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_StringLengthMax()
    {
        $_GET["testing"] = "hello_world";
        $_POST["magic"] = "do_the_thing";

        $input = new InputFilter();
        $reply = $input->get("testing")->checkStringLengthMax(50)->asString();
        $this->assertSame($reply, "hello_world", $input->getWhyFailed());

        $reply = $input->get("testing")->checkStringLengthMax(5)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->post("magic")->checkStringLengthMax(80)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->post("magic")->checkStringLengthMax(3)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_varInput()
    {
        $input = new InputFilter();
        $reply = $input->varInput("testing")->checkStringLengthMax(50)->asString();
        $this->assertSame($reply, "testing", $input->getWhyFailed());

        $reply = $input->varInput("what what say")->checkStringLengthMax(5)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->varInput("do_the_thing")->checkStringLengthMax(80)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->varInput("this is to long")->checkStringLengthMax(3)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->varInput("45")->checkInRange(30,50)->asInt();
        $this->assertSame($reply, 45, $input->getWhyFailed());

        $reply = $input->varInput("100")->checkGrtThanEq(300)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }

    public function test_base64()
    {
        $input = new InputFilter();
        $testing = "eyJ0b2tlbiI6ImNhdHMifQ==";
        $reply = $input->varInput($testing)->fromBase64()->isJson()->asArray();
        $this->assertSame(1, count($reply), "incorrect number of results");
        $this->assertSame("cats", $reply["token"], "Wrong token");

        $testing = "cGV0ZXIgaXMgZXZpbA==";
        $reply = $input->varInput($testing)->fromBase64()->asString();
        $this->assertSame("peter is evil", $reply, "wrong reply");
    }

    public function test_defaults()
    {
        $input = new InputFilter();
        $magic = $input->varInput(null)->asString("magic");
        $this->assertSame("magic", $magic, "Magic did not happen");

        $magic = $input->varInput("anti")->asString("magic");
        $this->assertSame("anti", $magic, "to much magic!");

        $magic = $input->varInput(null)->asInt(44);
        $this->assertSame(44, $magic, "Magic did not happen");

        $magic = $input->varInput(55)->asInt(44);
        $this->assertSame(55, $magic, "to much magic!");

        $magic = $input->varInput(null)->asFloat(44.5);
        $this->assertSame(44.5, $magic, "Magic did not happen");

        $magic = $input->varInput(55.554)->asFloat(44);
        $this->assertSame(55.554, $magic, "to much magic!");

        $magic = $input->varInput(null)->asArray([33,55]);
        $this->assertSame([33,55], $magic, "Magic did not happen");

        $_POST["yep"] = [33,55];
        $magic = $input->post("yep")->asArray([33,55]);
        $this->assertSame([33,55], $magic, "to much magic!");


    }
}
