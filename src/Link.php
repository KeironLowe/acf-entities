<?php

namespace ACFEntities;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Link extends FlexibleDataTransferObject
{
    public string $title;
    public string $url;
    public string $target;

    /**
     * Returns a new instance with the field data.
     *
     * @param string   $fieldName
     * @param int|null $postId
     * @return static|null
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public static function createFromField(string $fieldName, int $postId = null): ?Link
    {
        $postId = $postId ?? get_the_ID();

        if(!$fieldData = get_sub_field($fieldName, $postId)) {
            $fieldData = get_field($fieldName, $postId);
        }

        if(!$fieldData) {
            return null;
        }

        return new static($fieldData);
    }
}