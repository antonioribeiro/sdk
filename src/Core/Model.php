<?php
/**
 * Created by PhpStorm.
 * User: afaria
 * Date: 13/08/2014
 * Time: 13:10
 */

namespace PragmaRX\Sdk\Core;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

class Model extends Eloquent {

	use EventGenerator, PresentableTrait;

} 
