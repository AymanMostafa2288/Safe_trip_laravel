<?php
namespace App\Enum\Custom;
use App\Enum\BaseEnum;
class TransactionStatusEnum extends BaseEnum{
public const PENDING = "pending";
public const FAILED = "failed";
public const SUCCESS = "success";

}