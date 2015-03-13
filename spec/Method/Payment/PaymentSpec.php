<?php

namespace spec\Cardinity\Method\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentSpec extends ObjectBehavior
{
    function it_implements_result_object_behaviour()
    {
        $this->shouldImplement('Cardinity\Method\ResultObjectInterface');
    }

    function it_is_serializable()
    {
        $this->shouldImplement('\Serializable');

        $this->setId('foo');
        $this->setAmount(20.00);
        $this->setType(null);
        $this->serialize()->shouldReturn('{"id":"foo","amount":"20.00"}');
    }

    function it_is_unserializable()
    {
        $this->unserialize('{"id":"foo.bar.123","amount":"20.00"}');

        $this->getId()->shouldReturn('foo.bar.123');
        $this->getAmount()->shouldReturn(20.00);
        $this->getType()->shouldReturn(null);
    }
}
