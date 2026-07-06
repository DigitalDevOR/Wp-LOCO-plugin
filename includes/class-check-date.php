<?php

namespace Widget_Loco\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class CheckDate
{
    private \DateTime $abreveOnlineMaxDate;
    private \DateTime $appActivateMaxDate;

    public function __construct()
    {
        $this->abreveOnlineMaxDate = new \DateTime('2026-07-19 23:59:59', new \DateTimeZone('Europe/Rome'));
        $this->appActivateMaxDate = new \DateTime('2026-07-28 23:59:59', new \DateTimeZone('Europe/Rome'));
    }

    private function today(): \DateTime
    {
        return new \DateTime('now', new \DateTimeZone('Europe/Rome'));
    }

    public function getIsAbreveOnline(): bool
    {
        return $this->today() <= $this->abreveOnlineMaxDate;
    }

    public function getIsAppActive(): bool
    {
        return $this->today() > $this->abreveOnlineMaxDate
            && $this->today() <= $this->appActivateMaxDate;
    }

    public function getIsConcorsoTerminato(): bool
    {
        return $this->today() > $this->appActivateMaxDate;
    }
}