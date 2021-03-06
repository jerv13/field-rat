<?php

namespace Reliv\FieldRat\Api\FieldValidator;

use Reliv\ArrayProperties\Property;
use Reliv\FieldRat\Api\Field\FindFieldsByModel;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByFieldsModelName implements ValidateFields
{
    const OPTION_FIELDS_MODEL_NAME = 'fields-model-name';

    protected $findFieldsByModel;
    protected $validateFieldsByFieldsConfig;

    /**
     * @param FindFieldsByModel            $findFieldsByModel
     * @param ValidateFieldsByFieldsConfig $validateFieldsByFieldsConfig
     */
    public function __construct(
        FindFieldsByModel $findFieldsByModel,
        ValidateFieldsByFieldsConfig $validateFieldsByFieldsConfig
    ) {
        $this->findFieldsByModel = $findFieldsByModel;
        $this->validateFieldsByFieldsConfig = $validateFieldsByFieldsConfig;
    }

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $modelName = Property::getRequired(
            $options,
            static::OPTION_FIELDS_MODEL_NAME
        );

        $fieldsModel = $this->findFieldsByModel->__invoke(
            $modelName
        );

        if (empty($fieldsModel)) {
            throw new \Exception(
                'No fields found for field model: ' . $modelName
            );
        }

        $options[ValidateFieldsByFieldsConfig::OPTION_FIELDS_CONFIG] = $fieldsModel->getFieldsConfig();

        return $this->validateFieldsByFieldsConfig->__invoke(
            $fields,
            $options
        );
    }
}
