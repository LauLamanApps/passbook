<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;

class Field
{
    /** @var DataDetector[]|null */
    private ?array $dataDetectorTypes;
    private string $changeMessage;
    private TextAlignment $textAlignment;
    private string $attributedValue;
    /** @var SemanticTag[] */
    private array $semantics;

    /**
     * @param string|int|bool $value
     */
    public function __construct(
        private ?string $key = null,
        private null|string|int|bool|float $value = null,
        private ?string $label = null
    ) {
        if ($label !== null) {
            $this->setLabel($label);
        }
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function setValue(string|int|bool|float $value): void
    {
        $this->value = $value;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function addDataDetectorType(DataDetector $dataDetector): void
    {
        $this->dataDetectorTypes[$dataDetector->value] = $dataDetector;
    }

    public function setChangeMessage(string $changeMessage): void
    {
        $this->changeMessage = $changeMessage;
    }

    public function setTextAlignment(TextAlignment $textAlignment): void
    {
        $this->textAlignment = $textAlignment;
    }

    public function setAttributedValue(string $attributedValue): void
    {
        $this->attributedValue = $attributedValue;
    }

    public function addSemanticTag(SemanticTag $semanticTag): void
    {
        $this->semantics[] = $semanticTag;
    }

    /**
     * @return  array<string, array<int|string, mixed>|bool|int|string>
     */
    public function getMetadata(): array
    {
        $data = [
            'key' => $this->key,
            'value'=> $this->value,
        ];

        if (isset($this->label)) {
            $data['label'] = $this->label;
        }

        if (isset($this->dataDetectorTypes)) {
            foreach ($this->dataDetectorTypes as $dataDetector) {
                $data['dataDetectorTypes'][] = $dataDetector->value;
            }
        }

        if (isset($this->changeMessage)) {
            $data['changeMessage'] = $this->changeMessage;
        }

        if (isset($this->textAlignment)) {
            $data['textAlignment'] = $this->textAlignment->value;
        }

        if (isset($this->attributedValue)) {
            $data['attributedValue'] = $this->attributedValue;
        }

        if (isset($this->semantics)) {
            foreach ($this->semantics as $tag) {
                $data['semantics'][$tag->getKey()] = $tag->getValue();
            }
        }

        return $data;
    }
}
