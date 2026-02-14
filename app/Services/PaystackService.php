<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaystackService
{
    private string $secretKey;
    private string $publicKey;
    private string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key') ?? '';
        $this->publicKey = config('services.paystack.public_key') ?? '';
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/transaction/initialize', [
            'email' => $data['email'],
            'amount' => $data['amount'] * 100, // Convert to kobo/cents
            'currency' => $data['currency'] ?? 'NGN',
            'reference' => $data['reference'] ?? $this->generateReference(),
            'callback_url' => $data['callback_url'] ?? route('payment.callback'),
            'metadata' => $data['metadata'] ?? [],
        ]);

        return $response->json();
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment(string $reference): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
        ])->get($this->baseUrl . '/transaction/verify/' . $reference);

        return $response->json();
    }

    /**
     * Generate a unique payment reference
     */
    public function generateReference(): string
    {
        return 'PAY_' . strtoupper(Str::random(16)) . '_' . time();
    }

    /**
     * Create a payment record
     */
    public function createPaymentRecord(array $data): Payment
    {
        return Payment::create([
            'user_id' => $data['user_id'],
            'course_id' => $data['course_id'] ?? null,
            'counselor_booking_id' => $data['counselor_booking_id'] ?? null,
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NGN',
            'transaction_reference' => $data['reference'],
            'status' => 'pending',
        ]);
    }

    /**
     * Update payment status after verification
     */
    public function updatePaymentStatus(Payment $payment, array $verificationData): void
    {
        if ($verificationData['status'] && $verificationData['data']['status'] === 'success') {
            $payment->markAsCompleted($verificationData);
        } else {
            $payment->markAsFailed($verificationData);
        }
    }

    /**
     * Get public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
