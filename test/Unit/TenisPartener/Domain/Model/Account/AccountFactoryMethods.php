<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

//use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use TenisPartener\Domain\Model\Common\EmailAddress;
use TenisPartener\Domain\Model\Common\Level;
use TenisPartener\Domain\Model\Common\Title;

trait AccountFactoryMethods
{
    private function anAccountId(): AccountId
    {
        return AccountId::fromString('77d69702-e3b4-4af5-b40a-c9981d483880');
    }

//    private function aRandomAccountId(): AccountId
//    {
//        return AccountId::fromString(Uuid::uuid4()->toString());
//    }

    private function anEmailAddress(): EmailAddress
    {
        return EmailAddress::fromString('test@tenispartener.com');
    }

    private function aCanCreateAccountDateOfBirth(): CanCreateAccountDateOfBirth
    {
        $currentTime = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            '2020-10-30'
        );

        return CanCreateAccountDateOfBirth::fromInputData(
            DateOfBirth::fromString('2000-07-19'),
            $currentTime
        );
        //return DateOfBirth::fromString('2000-07-19');
    }

    private function aCannotCreateAccountDateOfBirth(): CanCreateAccountDateOfBirth
    {
        return CanCreateAccountDateOfBirth::fromInputData(
            DateOfBirth::fromString('2010-07-19'),
            $this->currentTime()
        );
    }

    private function aHashedPassword(): HashedPassword
    {
        return HashedPassword::createFromHashedString('sasdsfewgvregtryjytjygdwsqswqsq');
    }

    private function aFirstName(): string
    {
        return 'First Name Test';
    }

    private function aLastName(): string
    {
        return 'Last Name Test';
    }

    private function aCity(): string
    {
        return 'Timisoara(Timis)';
    }

    private function aLevel(): Level
    {
        return Level::fromInt(4);
    }

    private function aPhoneNumber(): string
    {
        return '0756123456';
    }

    private function aTitle(): Title
    {
        return Title::fromString('Doamna');
    }

    private function anAccount(): Account
    {
        $account = Account::create(
            $this->anAccountId(),
            $this->anEmailAddress(),
            $this->aHashedPassword(),
            $this->aFirstName(),
            $this->aLastName(),
            $this->aTitle(),
            $this->aCanCreateAccountDateOfBirth(),
            $this->aCity(),
            $this->aLevel(),
            $this->aPhoneNumber(),
            new DateTimeImmutable()
        );

        $account->releaseEvents();

        return $account;
    }

    private function currentTime(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            'Y-m-d',
            '2020-10-30'
        );
    }
}

