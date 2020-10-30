<?php

namespace Cardinity\Method\Payment;

use Cardinity\Method\MethodInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Finalize implements MethodInterface
{
    private $paymentId;
    private $authorizeData;
    private $finalizeKey;

    public function __construct($paymentId, $authorizeData, $isV2=false)
    {
        $this->paymentId = $paymentId;
        $this->authorizeData = $authorizeData;
        $this->finalizeKey = $isV2 ? 'cres' : 'authorize_data';
    }

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function getAuthorizeData()
    {
        return $this->authorizeData;
    }

    public function getAction()
    {
        return sprintf('payments/%s', $this->getPaymentId());
    }

    public function getMethod()
    {
        return MethodInterface::PATCH;
    }

    public function createResultObject()
    {
        return new Payment();
    }

    public function getAttributes()
    {
        return [
            $this->finalizeKey => $this->getAuthorizeData()
        ];
    }

    public function getValidationConstraints()
    {
        return new Assert\Collection([
            $this->finalizeKey => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
            ])
        ]);
    }
}
