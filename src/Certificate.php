<?php

namespace TmrwLife\NtakGuru;

class Certificate extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $accommodation): array
    {
        return $this->get("/v1/accommodations/$accommodation/certificates");
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
    public function upload(string $accommodation, string $certificate, string $reportingId): array
    {
        return $this->put("/v1/accommodations/$accommodation/certificates", [
            'certificate' => $certificate,
            'reporting_id' => $reportingId,
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
