<?php

namespace Cardinity\Method\PaymentLink;

use Cardinity\Method\MethodInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Cardinity\Method\Validators\CallbackUrlConstraint;


class Create implements MethodInterface
{
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAction(): string
    {
        return 'paymentLinks';
    }

    public function getMethod(): string
    {
        return MethodInterface::POST;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function createResultObject(): PaymentLink
    {
        return new PaymentLink();
    }

    public function getValidationConstraints()
    {
        return new Assert\Collection([
            //required fields
            'amount' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'float'])
            ]),
            'currency' => new Assert\Required([
                new Assert\Type(['type' => 'string']),
                new Assert\Length([
                    'min' => 3,
                    'max' => 3
                ]),
            ]),
            'description' => new Assert\Required([
                new Assert\Type(['type' => 'string']),
                new Assert\Length([
                    'max' => 255
                ]),
            ]),

            //optional fields
            'country' => new Assert\Optional([
                new Assert\Type(['type' => 'string']),
                new Assert\Length([
                    'min' => 2,
                    'max' => 2
                ]),
            ]),
            //TODO:: verify string is 2023-01-06T15:26:03.702Z  RFC 3339 Section 5.6. UTC datetime string
            'expiration_date' => new Assert\Optional([
                new Assert\Type(['type' => 'string']),
                new Assert\Length([
                    'min' => 24,
                    'max' => 24
                ]),
            ]),
            'multiple_use' => new Assert\Optional([
                new Assert\Type(['type' => 'bool']),
            ]),
        ]);
    }
}
