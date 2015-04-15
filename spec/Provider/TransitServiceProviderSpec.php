<?php

namespace spec\Kenarkose\Transit\Provider;


use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TransitServiceProviderSpec extends LaravelObjectBehavior {

    function let()
    {
        $this->beConstructedWith(app());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kenarkose\Transit\Provider\TransitServiceProvider');
    }

    function it_registers_services()
    {
        $this->register();
    }

}
