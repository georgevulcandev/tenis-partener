<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

interface PartnerMatchRepository
{
    public function save(PartnerMatch $partnerMatch): void;

    /**
     * @throws CouldNotFindPartnerMatch
     */
    public function getById(PartnerMatchId $partnerMatchId): PartnerMatch;

    public function nextIdentity(): PartnerMatchId;
}
