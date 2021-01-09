<?php
declare(strict_types=1);

namespace TenisPartener\Application\Account;

use TenisPartener\Domain\Model\Account\DateOfBirth;
use TenisPartener\Domain\Model\Account\Password;
use TenisPartener\Domain\Model\Common\EmailAddress;
use TenisPartener\Domain\Model\Common\Level;
use TenisPartener\Domain\Model\Common\Title;
use TenisPartener\Infrastructure\Mapping;

final class CreateAccount
{
    use Mapping;

    private string $emailAddress;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $title;
    private string $dateOfBirth;
    private string $city;
    private int $level;
    private string $phoneNumber;

    public function __construct(
        string $emailAddress,
        string $password,
        string $firstName,
        string $lastName,
        string $title,
        string $dateOfBirth,
        string $city,
        int $gameLevel,
        string $phoneNumber
    ) {
        $this->emailAddress = $emailAddress;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->title = $title;
        $this->dateOfBirth = $dateOfBirth;
        $this->city = $city;
        $this->level = $gameLevel;
        $this->phoneNumber = $phoneNumber;
    }

    public static function fromRequestData(array $data): self
    {
        return new self(
            self::asString($data, 'email'),
            self::asString($data, 'password'),
            self::asString($data, 'firstName'),
            self::asString($data, 'lastName'),
            self::asString($data, 'title'),
            self::asString($data, 'dateOfBirth'),
            self::asString($data, 'city'),
            self::asInt($data, 'level'),
            self::asString($data, 'phoneNumber')
        );
    }

    public function emailAddress(): EmailAddress
    {
        return EmailAddress::fromString($this->emailAddress);
    }

    public function password(): Password
    {
        return Password::createFromPlainText($this->password);
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function title(): Title
    {
        return Title::fromString($this->title);
    }

    public function dateOfBirth(): DateOfBirth
    {
        //return DateOfBirth::fromString($this->dateOfBirth));
        return DateOfBirth::fromString($this->dateOfBirth);
    }

    public function city(): string
    {
        return $this->city;
    }

    public function level(): Level
    {
        return Level::fromInt($this->level);
    }

    public function phoneNumber(): string
    {
        return $this->phoneNumber;
    }
}