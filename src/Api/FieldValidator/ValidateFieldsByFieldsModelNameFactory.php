<?php

namespace Reliv\FieldRat\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\Field\FindFieldsByModel;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByFieldsModelNameFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsByFieldsModelName
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsByFieldsModelName(
            $serviceContainer->get(FindFieldsByModel::class),
            $serviceContainer->get(ValidateFieldsByFieldsConfig::class)
        );
    }
}
