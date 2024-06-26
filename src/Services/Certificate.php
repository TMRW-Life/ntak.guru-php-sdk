<?php

namespace TmrwLife\NtakGuru\Services;

use GuzzleHttp\RequestOptions;

class Certificate extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $accommodation): string
    {
        $response = $this->client->get("/v1/accommodations/$accommodation/certificates", [
            RequestOptions::HEADERS => [
                'Accept' => 'application/pkcs10',
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generate(string $accommodation): void
    {
        $this->post("/v1/accommodations/$accommodation/certificates");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(string $accommodation, string $certificate): array
    {
        return $this->put("/v1/accommodations/$accommodation/certificates", [
            'certificate' => $certificate,
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy(string $accommodation): void
    {
        $this->delete("/v1/accommodations/$accommodation/certificates");
    }
}
