<?php

namespace TmrwLife\NtakGuru\Tests\Services;

use TmrwLife\NtakGuru\Services\Certificate;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CertificateTest extends TestCase
{
    use WithFaker;

    public function testItDownloadCertificateRequest(): void
    {
        $gateway = Certificate::fake([
            'payload' => [
                'certificateRequest' => $csr = $this->faker->text(),
            ],
        ]);

        $response = $gateway->download($this->faker->uuid());

        $this->assertSame($csr, $response['payload']['certificateRequest']);
    }

    public function testItUploadsTheCertificate(): void
    {
        $gateway = Certificate::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->upload($id, $this->faker->text(), $this->faker->word());

        $this->assertSame($id, $response['payload']['id']);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testItGeneratesCertificate(): void
    {
        $gateway = Certificate::fake(null);

        $gateway->generate($this->faker->uuid());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testItDestroysCertificate(): void
    {
        $gateway = Certificate::fake(null);

        $gateway->destroy($this->faker->uuid());
    }
}
