<?php

namespace ACFEntities;

use DateTime;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Attachment extends FlexibleDataTransferObject
{
    public int $id;
    public string $title;
    public string $filename;
    public int $filesize;
    public string $url;
    public string $link;
    public string $author;
    public string $description;
    public string $caption;
    public string $name;
    public string $status;
    public int $uploaded_to;
    public string $date;
    public string $modified;
    public int $menu_order;
    public string $mime_type;
    public string $type;
    public string $subtype;

    /**
     * Returns a new instance with the field data.
     *
     * @param string   $fieldName
     * @param int|string|null $postId
     * @return static
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public static function createFromField(string $fieldName, $postId = null): ?self
    {
        $postId = $postId ?? get_the_ID();

        if (!$fieldData = get_sub_field($fieldName, $postId)) {
            $fieldData = get_field($fieldName, $postId);
        }

        return $fieldData ? new static($fieldData) : null;
    }

    /**
     * Returns the filesize as a human readable string
     *
     * @param int $precision
     * @return string
     */
    public function getHumanReadableFileSize(int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($this->filesize, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Returns the URL for the image, optionally at a given size.
     *
     * @param string|null $size
     * @return string|null
     */
    public function getUrl(string $size = null): ?string
    {
        return $this->url;
    }

    /**
     * Returns a WP_User instance for the user who uploaded the image.
     *
     * @return false|\WP_User
     */
    public function getAuthor()
    {
        return get_userdata($this->author);
    }

    /**
     * Returns the created date, in an optional format.
     *
     * @param string|null $format
     * @return string
     */
    public function getCreatedDate(string $format = null): string
    {
        if($format) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $this->date)->format($format);
        }

        return $this->date;
    }

    /**
     * Returns the modified date, in an optional format.
     *
     * @param string|null $format
     * @return string
     */
    public function getModifiedDate(string $format = null): string
    {
        if($format) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $this->modified)->format($format);
        }

        return $this->modified;
    }
}