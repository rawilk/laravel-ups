<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $http_user_agent
 *      Browser HTTPUserAgent String. This is the preferred way of identifying GIF image type to be generated.
 * @property null|string $character_set
 * @property \Rawilk\Ups\Entity\Shipment\Label\LabelPrintMethod $label_print_method
 * @property null|\Rawilk\Ups\Entity\Shipment\Label\LabelStockSize $label_stock_size
 *      For EPL2, ZPL, STARPL, and SPL labels.
 * @property \Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat $label_image_format
 * @property null|\Rawilk\Ups\Entity\Shipment\Label\Instruction $instruction
 */
class LabelSpecification extends Entity
{
    // Character sets
    public const CHAR_DANISH = 'dan';

    public const CHAR_DUTCH = 'nld';

    public const CHAR_FINNISH = 'fin';

    public const CHAR_FRENCH = 'fra';

    public const CHAR_GERMAN = 'deu';

    public const CHAR_ITALIAN = 'itl';

    public const CHAR_NORWEGIAN = 'nor';

    public const CHAR_POLISH = 'pol';

    public const CHAR_PORTUGUESE = 'por';

    public const CHAR_SPANISH = 'spa';

    public const CHAR_SWEDISH = 'swe';

    public const CHAR_CZECH = 'ces';

    public const CHAR_HUNGARIAN = 'hun';

    public const CHAR_SLOVAK = 'slk';

    public const CHAR_RUSSIAN = 'rus';

    public const CHAR_TURKISH = 'tur';

    public const CHAR_ROMANIAN = 'ron';

    public const CHAR_BULGARIAN = 'bul';

    public const CHAR_ESTONIAN = 'est';

    public const CHAR_GREEK = 'ell';

    public const CHAR_LATVIAN = 'lav';

    public function getHttpUserAgentXmlTag(): string
    {
        return 'HTTPUserAgent';
    }

    public function labelImageFormat(): string
    {
        return LabelImageFormat::class;
    }

    public function labelPrintMethod(): string
    {
        return LabelPrintMethod::class;
    }

    public function labelStockSize(): string
    {
        return LabelStockSize::class;
    }

    public function instruction(): string
    {
        return Instruction::class;
    }

    public function getLabelStockSizeAttribute($labelStockSize): ?LabelStockSize
    {
        if ($labelStockSize) {
            return $labelStockSize;
        }

        return $this->label_print_method->needsLabelStockSize()
            ? new LabelStockSize
            : null;
    }

    public static function asGIF(): self
    {
        return new static([
            'label_print_method' => new LabelPrintMethod([
                'code' => LabelPrintMethod::IMAGE,
            ]),
            'label_image_format' => new LabelImageFormat([
                'code' => LabelImageFormat::GIF,
            ]),
        ]);
    }

    public static function asPNG(): self
    {
        return new static([
            'label_print_method' => new LabelPrintMethod([
                'code' => LabelPrintMethod::IMAGE,
            ]),
            'label_image_format' => new LabelImageFormat([
                'code' => LabelImageFormat::PNG,
            ]),
        ]);
    }
}
