<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DigitalSignature extends Model
{
    protected $fillable = [
        'signable_type',
        'signable_id',
        'user_id',
        'signature_data',
        'signature_type',
        'ip_address',
        'user_agent',
        'location',
        'gps_coordinates',
        'signed_at',
        'is_valid',
        'verification_hash',
        'certificate_data',
        'purpose',
        'legal_disclaimer'
    ];

    protected $casts = [
        'signature_data' => 'array',
        'gps_coordinates' => 'array',
        'certificate_data' => 'array',
        'signed_at' => 'datetime',
        'is_valid' => 'boolean'
    ];

    /**
     * Get the signable model (polymorphic relationship).
     */
    public function signable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who created the signature.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate verification hash for the signature.
     */
    public static function generateVerificationHash(array $signatureData): string
    {
        return hash('sha256', json_encode($signatureData) . config('app.signature_secret'));
    }

    /**
     * Verify signature integrity.
     */
    public function verifySignature(): bool
    {
        $expectedHash = self::generateVerificationHash([
            'signable_type' => $this->signable_type,
            'signable_id' => $this->signable_id,
            'user_id' => $this->user_id,
            'signature_data' => $this->signature_data,
            'signed_at' => $this->signed_at->timestamp
        ]);

        return hash_equals($expectedHash, $this->verification_hash);
    }

    /**
     * Create digital signature for document.
     */
    public static function createSignature($signable, User $user, array $signatureData, string $purpose = ''): self
    {
        $signature = new self([
            'signable_type' => get_class($signable),
            'signable_id' => $signable->id,
            'user_id' => $user->id,
            'signature_data' => $signatureData,
            'signature_type' => $signatureData['type'] ?? 'digital',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'location' => $signatureData['location'] ?? null,
            'gps_coordinates' => $signatureData['gps_coordinates'] ?? null,
            'signed_at' => now(),
            'purpose' => $purpose,
            'legal_disclaimer' => 'This digital signature is legally binding under Tanzanian Electronic Transactions Act, 2015.'
        ]);

        $signature->verification_hash = $signature->generateVerificationHash([
            'signable_type' => $signature->signable_type,
            'signable_id' => $signature->signable_id,
            'user_id' => $signature->user_id,
            'signature_data' => $signature->signature_data,
            'signed_at' => $signature->signed_at->timestamp
        ]);

        $signature->is_valid = true;
        $signature->save();

        return $signature;
    }

    /**
     * Get signature image data URL.
     */
    public function getSignatureImageUrlAttribute(): string
    {
        if ($this->signature_data['type'] === 'image' && isset($this->signature_data['image'])) {
            return $this->signature_data['image'];
        }
        
        return '';
    }

    /**
     * Get signature text representation.
     */
    public function getSignatureTextAttribute(): string
    {
        if ($this->signature_data['type'] === 'typed' && isset($this->signature_data['text'])) {
            return $this->signature_data['text'];
        }
        
        return '';
    }

    /**
     * Check if signature is legally valid.
     */
    public function isLegallyValid(): bool
    {
        return $this->is_valid &&
               $this->verifySignature() &&
               $this->signed_at &&
               $this->user_id;
    }
}
