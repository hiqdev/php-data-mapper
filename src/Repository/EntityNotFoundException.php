<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Repository;

use Throwable;

/**
 * Class EntityNotFoundException.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class EntityNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: 'Entity was not found', $code, $previous);
    }
}
