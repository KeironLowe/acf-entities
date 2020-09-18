<?php

namespace ACFEntities;

class Image extends Attachment
{
    public array $sizes;
    public string $alt;

    /**
     * Returns the URL for the image, optionally at a given size.
     *
     * @param string|null $size
     * @return string|null
     */
    public function getUrl(string $size = null): ?string
    {
        if($size) {
            return $this->sizes[$size];
        }

        return $this->url;
    }

    /**
     * Returns the width of the image, optionally the width of a resize.
     *
     * @param string|null $size
     * @return int|null
     */
    public function getWidth(string $size = null): ?int
    {
        if($size) {
            return $this->sizes["$size-width"];
        }

        return $this->width;
    }

    /**
     * Returns the height of the image, optionally the height of a resize.
     *
     * @param string|null $size
     * @return int|null
     */
    public function getHeight(string $size = null): ?int
    {
        if($size) {
            return $this->sizes["$size-height"];
        }

        return $this->height;
    }

    /**
     * Returns the value for srcset attribute.
     *
     * @param string|null $size
     * @return string
     */
    public function getSrcset(string $size = null): string
    {
        return wp_get_attachment_image_srcset($this->id, $size);
    }
}