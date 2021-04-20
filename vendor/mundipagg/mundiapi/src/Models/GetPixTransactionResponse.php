<?php
/*
 * MundiAPILib
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace MundiAPILib\Models;

use JsonSerializable;
use MundiAPILib\Utils\DateTimeHelper;

/**
 *Response object when getting a pix transaction
 *
 * @discriminator transaction_type
 * @discriminatorType pix
 */
class GetPixTransactionResponse extends GetTransactionResponse implements JsonSerializable
{
    /**
     * @todo Write general description for this property
     * @required
     * @maps qr_code
     * @var string $qrCode public property
     */
    public $qrCode;

    /**
     * @todo Write general description for this property
     * @required
     * @maps qr_code_url
     * @var string $qrCodeUrl public property
     */
    public $qrCodeUrl;

    /**
     * @todo Write general description for this property
     * @required
     * @maps expires_at
     * @factory \MundiAPILib\Utils\DateTimeHelper::fromRfc3339DateTime
     * @var \DateTime $expiresAt public property
     */
    public $expiresAt;

    /**
     * @todo Write general description for this property
     * @required
     * @maps additional_information
     * @var \MundiAPILib\Models\PixAdditionalInformation[] $additionalInformation public property
     */
    public $additionalInformation;

    /**
     * Constructor to set initial or default values of member properties
     * @param string    $qrCode                Initialization value for $this->qrCode
     * @param string    $qrCodeUrl             Initialization value for $this->qrCodeUrl
     * @param \DateTime $expiresAt             Initialization value for $this->expiresAt
     * @param array     $additionalInformation Initialization value for $this->additionalInformation
     */
    public function __construct()
    {
        if (4 == func_num_args()) {
            $this->qrCode                = func_get_arg(0);
            $this->qrCodeUrl             = func_get_arg(1);
            $this->expiresAt             = func_get_arg(2);
            $this->additionalInformation = func_get_arg(3);
        }
    }


    /**
     * Encode this object to JSON
     */
    public function jsonSerialize()
    {
        $json = array();
        $json['qr_code']                = $this->qrCode;
        $json['qr_code_url']            = $this->qrCodeUrl;
        $json['expires_at']             = DateTimeHelper::toRfc3339DateTime($this->expiresAt);
        $json['additional_information'] = $this->additionalInformation;
        $json = array_merge($json, parent::jsonSerialize());

        return $json;
    }
}
