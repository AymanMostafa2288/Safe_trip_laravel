<?php
namespace App\Enum\Custom;
use App\Enum\BaseEnum;
class StudentTripStatusEnum extends BaseEnum{
public const WAITING = "waiting";
public const ABSENT = "absent";
public const ON_THE_WAY = "on_the_way";
public const ARRIVED = "arrived";

}