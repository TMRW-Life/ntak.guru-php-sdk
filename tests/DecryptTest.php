<?php

namespace TmrwLife\NtakGuru\Tests;

use TmrwLife\NtakGuru\Crypt;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;

class DecryptTest extends TestCase
{
    public function testItDecryptsTheContext(): void
    {
        $encrypted = 'AMb70MRQ3Jr9AqEJzFt1qe+mrwLn03u8JW8KuxTxPExDE6vDyeL3aZFUudw8RzwYNRApZwmP3Mp2L/TiYVQC7d1c1HcC0b0iePYE/hoEOYiD7WrJyBJmKvHGzGKyrBSV8djrQFAYqJvnwUJmDidK4L0GKcEWbVfOIKd0pn430o4f5228MaHAP6zYzS9IuPzCeC42+Aho5lsfs+u8eMUo219JmCH7GQv/eYoyldZJunfFLO//cL/t6fEr7gnX5WaMFzAO2t0Ni5K7eg55wYHtIRej+6C0eoVL2i2WBXiWoxdhtRdC/Av9UUkrCsoSIb4ddP7aU22/lb8g6E9EiruzPqbFQcQc1jYSxi6P7Qe2DxeQYugqYBp8DhqYyffe9qIyujUuETYwWw5IuFjZsspYhBHMucEEWxmluX2z6qnLaLG5qdSbJnwk38KIrjd7ZNq6ad5nygjNLKfQmqYizTo20o3D36sX4P9LkpO2Ny/gvJzZfqyLr+3ejSXik30HSZupzRoS0THXsJyS8uXpMsyVnzd8pkrzX0UOMnibVtubymlU8G8t7IbBtjF9xTIc0DkOAdKfbBtz87U2u+Fw3bDvor1+pQ2A0YwHMUWMk7RRVVzliN1aAcqmOy0fdo5vHfoG4j4z1romtja6waps7xdHbJXe9orTdgyrUb/IjUX2pCQ=';

        $context = Crypt::decrypt($encrypted);

        $this->assertSame('2022-03-02 10:32:48', $context['occurredAt']);
        $this->assertSame('55519', $context['reservationNumber']);
        $this->assertSame('1987-08-29', $context['arrival']);
        $this->assertSame('1993-11-15', $context['departure']);
        $this->assertFalse($context['cancelled']);
        $this->assertSame(9, $context['guestCount']);
        $this->assertSame(MarketSegment::BUSINESS_GROUP->value, $context['marketSegment']);
        $this->assertSame('1994-11-09 23:26:49', $context['reservedAt']);
        $this->assertSame(SalesChannel::DIRECTLY_ONLINE->value, $context['salesChannel']);
        $this->assertSame(43215.17, $context['grossAmount']);
        $this->assertSame('LY', $context['nationality']);
        $this->assertSame(ResidentialUnitType::JUNIOR_SUITE->value, $context['bookedResidentialUnits'][0]['type']);
        $this->assertSame(3, $context['bookedResidentialUnits'][0]['capacity']);
    }

    public function testItReturnsFalseIfTheDataIsNull(): void
    {
        $context = Crypt::decrypt(null);

        $this->assertFalse($context);
    }

    public function testItReturnsFalseIfDecryptFailed(): void
    {
        $encrypted = 'AMb70MRQ3Jr9AqEJzFt1qe+mrwLn03u8JW8KuxTxPExDE6vDyeL3aZFUudw8RzwYNRApZwmP3M';

        $context = Crypt::decrypt($encrypted);

        $this->assertFalse($context);
    }
}
