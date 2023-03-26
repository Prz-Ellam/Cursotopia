<?php

namespace Cursotopia\Models;

use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Required;

class VideoModel {
    #[Required("El tipo de la imagen es requerido")]
    #[Enum([ "video/mp4", "video/webm", "video/ogg" ], "El tipo de imagen no es válido")]
    private ?string $contentType;
}
