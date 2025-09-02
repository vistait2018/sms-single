<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    /**
     * Generate and store a 6-digit OTP for a user
     */
    public static function generateOtpCode(int $userId): int
    {
        $otpCode = rand(100000, 999999);

        Otp::create([
            'user_id' => $userId,
            'otp'     => Hash::make($otpCode), // store hashed
        ]);

        return $otpCode; // return plain code for sending via SMS/email
    }

    /**
     * Validate the OTP for a given user
     */
    public static function validateOtp(int $userId, string $otpInput, int $validMinutes = 5): array
    {
        $otp = Otp::where('user_id', $userId)->latest()->first();

        if (!$otp) {
            return [
                'status'  => false,
                'message' => 'OTP not found',
            ];
        }

        // Check if expired based on created_at
        if ($otp->created_at->addMinutes($validMinutes)->isPast()) {
            return [
                'status'  => false,
                'message' => 'OTP has expired',
            ];
        }

        // Verify hash
        if (!Hash::check($otpInput, $otp->otp)) {
            return [
                'status'  => false,
                'message' => 'Invalid OTP',
            ];
        }

        return [
            'status'  => true,
            'message' => 'OTP verified successfully',
        ];
    }
}
