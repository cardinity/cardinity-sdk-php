<?php

namespace spec\Cardinity\Http\Guzzle;

use Cardinity\Http\Guzzle\ExceptionMapper;
use Cardinity\Method\MethodInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class ClientAdapterSpec extends ObjectBehavior
{
    function let(
        ClientInterface $client,
        ExceptionMapper $mapper
    ) {
        $this->beConstructedWith($client, $mapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cardinity\Http\Guzzle\ClientAdapter');
    }

    function it_sends_post_and_returns_result(
        MethodInterface $method,
        ClientInterface $client,
        ResponseInterface $response
    ) {
        $response
            ->getBody()
            ->shouldBeCalled()
            ->willReturn(json_encode(['foo' => 'bar']))
        ;
        $client
            ->request('POST', 'https://api.cardinity.com/v1/', [])
            ->shouldBeCalled()
            ->willReturn($response)
        ;
        $this
            ->sendRequest($method, 'POST', 'https://api.cardinity.com/v1/', [])
            ->shouldReturn(['foo' => 'bar'])
        ;
    }

    function it_throws_client_exceptions(
        MethodInterface $method,
        ClientInterface $client,
        ExceptionMapper $mapper,
        ClientException $exception
    ) {
        $client
            ->request('POST', 'https://api.cardinity.com/v1/', [])
            ->willThrow($exception->getWrappedObject())
        ;
    }

    function it_handles_unexpected_exceptions(
        MethodInterface $method,
        ClientInterface $client,
        \Exception $exception
    )
    {
        $client
            ->request('POST', 'https://api.cardinity.com/v1/', [])
            ->willThrow($exception->getWrappedObject())
        ;
        $this
            ->shouldThrow('Cardinity\Exception\UnexpectedError')
            ->duringSendRequest($method, 'POST', 'https://api.cardinity.com/v1/')
        ;
    }
}
