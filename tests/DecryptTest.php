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
        $encrypted = 'hVcbND1lK5HUps7sa2uhCfd0MGw2UuzqFSJ4m8f54Zfk5L3HJxa9fiNRfWKqNHmZLX3kJZytpCu8uiKWF1o0ASjdENKegxbXOR8uc8UvBeDOlJOdgNB9zOhbmCGEUI8nxyCnLTdvthfu+dxjFT3M27ov7yQV7IvLqJtZGIWB+kFvXviBykh1yNzmGdjV5RMpyWQGlTq1h0onGyAvPlKp/U3ehtnmejjMlCjUoWj5Zg323dWjIGG3hpf1GusBSh1XnLq6XPjvhMT5/R8v2dUYeQEgkGG4b2ZLaXeHfVs2nynauwTiq6bZcReIucStJAvY9sBCdi00INLzuafFTWarxiSsKXO329InYGmQZw8zYw5wMK+44XFqcE7W8ht9tz4cC+X1pf/lTn3ihblipJmJtbQpSKlPYzu/m1/+YnHFTnzM8Oa+YV5naTscOtEKH4VlR97yjwh37pgnw6uD7j4nPXl1da6OJkKvvjJYP8rjIsnvkDMNqLx/acS/u//O84AwHdSrw1Fk6WYtMl3OFBNzcz0N4uBJK5MgPC9PTQNPQIyL2ysUVo6+o/nstFQh3cdgDjKbD10BqochaeySzM+fLFzJY9a7VO7fPf1OOTUiH5w4orid6ZcDjERWmYNSmEFhRsaTwNyZasuhRzLzySH68vMK+FL2Azg3C8MbP2/RXnM=,C6mYe2UWuwfEs8B1XbepmRJomwkQ/MTfO+UpyG4TDmGX2SvHdAtPdHBfSGs0ovoF0h5lS9/7HKlklkFVJwhiMPhFuCjpJHf59nQqcDzmFlnlrhlEq97qbjVMQyCbfHu6mqoUHeETia3W+M1HnLs6NNVGRbgxNsTUiSNBUYnD/3cAyRuVNakrplxEXOr2VlaSNILuFPxmms6TZ8vHv/R0noV/20M0r+HcEX2ebhrZAsCpXBjpxzTeWJSsbbXFpURlltuxCPw+X55zR8p/hmQNqsbZdV917f/6xf0nD3sMYN4tPr07ND5RS6mj3RPTVGVs+TxRXl7cypa8R+uh/YQdarG9JLFERaGriLMKoooTnxpn0PUrnTGM+QpWn3kFeg0LYgiLAbCdZYY/TeZvHpkdSmCMa3zcxaWB8xARq+VddSsmV+QpE73d3rW/AFxnBu+Mt3Kh5oW8EgcVBu8UgD9XcBUyKkKhmst/eWj4CLkkAGVR4/7K94Vis+Is56fMyB7zAz3ZXGQKEbRaAOJSFER+xKzW//0FoLaLqZt8MWg7y1VRr9EIGxh51hKZPQiBxcaKLA+mXff1umCYhDNKeHa5Clr5hBKWuu+Il/AfJzT5wHta0/p1Qb86lV6SeF1y9mYeVDb9dLtIMg9edAHoFqkTL8wqdTZiNb3zNezWy1LkK7Y=';

        $context = Crypt::decrypt($encrypted);

        $this->assertSame('2022-03-02 10:32:48', $context['occurredAt']);
        $this->assertSame('55519', $context['reservationNumber']);
        $this->assertSame('1987-08-29', $context['arrival']);
        $this->assertSame('1993-11-15', $context['departure']);
        $this->assertFalse($context['cancelled']);
        $this->assertSame(9, $context['guestCount']);
        $this->assertSame(MarketSegment::BUSINESS_GROUP->value, $context['marketSegment']);
        $this->assertSame('1994-11-09 23:26:49', $context['reservedAt']);
        $this->assertSame(SalesChannel::DIRECT_ONLINE->value, $context['salesChannel']);
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
