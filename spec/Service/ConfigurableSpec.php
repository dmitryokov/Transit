<?php

namespace spec\Kenarkose\Transit\Service;


use Kenarkose\Transit\Service\Configurable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurableSpec extends ObjectBehavior {

    function let()
    {
        $this->beAnInstanceOf('spec\Kenarkose\Transit\Service\ConfigurableTest');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Kenarkose\Transit\Service\ConfigurableTest');
    }

    function it_gets_and_sets_model_name()
    {
        $this->modelName()->shouldBe('Kenarkose\Transit\File');

        $this->modelName('Some\Other\Instance\Upload')->shouldBe('Some\Other\Instance\Upload');

        $this->modelName()->shouldBe('Some\Other\Instance\Upload');
    }
}

class ConfigurableTest {

    use Configurable;

}