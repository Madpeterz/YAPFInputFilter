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
        $reply = $input->varinput("testing")->checkStringLengthMax(50)->asString();
        $this->assertSame($reply, "testing", $input->getWhyFailed());

        $reply = $input->varinput("what what say")->checkStringLengthMax(5)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->varinput("do_the_thing")->checkStringLengthMax(80)->asString();
        $this->assertSame($reply, "do_the_thing", $input->getWhyFailed());

        $reply = $input->varinput("this is to long")->checkStringLengthMax(3)->asString();
        $this->assertSame($reply, null, "Expected the reply to be null");

        $reply = $input->varinput("45")->checkInRange(30,50)->asInt();
        $this->assertSame($reply, 45, $input->getWhyFailed());

        $reply = $input->varinput("100")->checkGrtThanEq(300)->asInt();
        $this->assertSame($reply, null, "Expected the reply to be null");
    }
}
