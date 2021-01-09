<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

final class PartnerMatchWasAdded
{
    private PartnerMatch $partnerMatch;

    public function __construct(PartnerMatch $partnerMatch)
    {
        $this->partnerMatch = $partnerMatch;
    }

    public function partnerMatch(): PartnerMatch
    {
        return $this->partnerMatch;
    }
}