<?php
declare(strict_types=1);

namespace hiqdev\DataMapper\Query\Field;

use hiqdev\DataMapper\Query\Builder\QueryConditionBuilderInterface;

/**
 * Interface BuilderAwareFieldInterface can be used with {@see FieldInterface}
 * and override choosing of a builder class.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface BuilderAwareFieldInterface extends FieldInterface
{
    /**
     * Returns a modified copy of the object
     *
     * @param class-string<QueryConditionBuilderInterface> $className
     * @return $this
     */
    public function buildWith(string $className);

    /**
     * @return class-string<QueryConditionBuilderInterface>|null
     */
    public function getBuilderClass(): ?string;
}
