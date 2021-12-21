<?php

declare(strict_types=1);

namespace App\Infrastructure;

use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class DateRange implements Arrayable
{
    /**
     * @param  Carbon  $from
     * @param  Carbon  $to
     */
    public function __construct(
        private Carbon $from,
        private Carbon $to,
    ) {
    }

    /**
     * @return Carbon
     */
    #[Pure]
    public function getFrom(): Carbon
    {
        return $this->from->clone();
    }

    /**
     * @return Carbon
     */
    #[Pure]
    public function getTo(): Carbon
    {
        return $this->to->clone();
    }

    /**
     * @param  string  $period
     * @return static
     */
    public static function parse(string $period): self
    {
        if (str_contains($period, ':')) {
            $split = explode(':', $period, 2);
            return new self(
                Carbon::parse($split[0])->startOfDay(),
                Carbon::parse($split[1])->startOfDay(),
            );
        }

        throw new InvalidArgumentException("Invalid date range format");
    }

    /**
     * @return Carbon[]
     */
    #[Pure]
    #[ArrayShape(['from' => Carbon::class, 'to' => Carbon::class])]
    public function toArray(): array
    {
        return [
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
        ];
    }
}
