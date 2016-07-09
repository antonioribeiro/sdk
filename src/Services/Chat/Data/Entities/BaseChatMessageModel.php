<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Chat\Data\Contracts\Senderable;

abstract class BaseChatMessageModel extends Model implements Senderable
{

}
