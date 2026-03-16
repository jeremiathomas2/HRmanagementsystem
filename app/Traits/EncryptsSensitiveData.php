<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

trait EncryptsSensitiveData
{
    /**
     * Encrypt sensitive data before saving.
     */
    public function setAttribute($key, $value)
    {
        // Check if attribute should be encrypted
        if ($this->shouldEncrypt($key) && $value !== null) {
            $value = $this->encryptData($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Decrypt sensitive data when retrieving.
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // Check if attribute should be decrypted
        if ($this->shouldEncrypt($key) && $value !== null) {
            $value = $this->decryptData($value);
        }

        return $value;
    }

    /**
     * Determine if an attribute should be encrypted.
     */
    protected function shouldEncrypt($key): bool
    {
        $encryptedAttributes = $this->getEncryptedAttributes();

        return in_array($key, $encryptedAttributes);
    }

    /**
     * Get list of attributes that should be encrypted.
     */
    protected function getEncryptedAttributes(): array
    {
        return [
            // Employee sensitive data
            'national_id',
            'passport_number',
            'work_permit_number',
            'bank_account',
            'tax_number',
            'nssf_number',
            'wcf_number',
            'medical_information',
            'emergency_contact_phone',
            
            // Payroll sensitive data
            'bank_details',
            'salary_details',
            
            // Discipline sensitive data
            'witness_details',
            'investigation_notes',
            
            // Personal contact information
            'phone',
            'address',
            'emergency_contact_name',
        ];
    }

    /**
     * Encrypt data using AES-256.
     */
    protected function encryptData($value): string
    {
        try {
            return Crypt::encrypt($value);
        } catch (\Exception $e) {
            \Log::error('Encryption failed: ' . $e->getMessage());
            throw new \Exception('Data encryption failed');
        }
    }

    /**
     * Decrypt data using AES-256.
     */
    protected function decryptData($value)
    {
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            \Log::error('Decryption failed: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            \Log::error('Decryption error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Encrypt JSON data.
     */
    protected function encryptJsonData($data): string
    {
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }

        return $this->encryptData($data);
    }

    /**
     * Decrypt JSON data.
     */
    protected function decryptJsonData($encryptedData)
    {
        $decrypted = $this->decryptData($encryptedData);
        
        if ($decrypted === null) {
            return null;
        }

        $decoded = json_decode($decrypted, true);
        
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $decrypted;
    }

    /**
     * Check if data is encrypted.
     */
    protected function isEncrypted($value): bool
    {
        try {
            Crypt::decrypt($value);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }

    /**
     * Get encryption key info (for audit purposes).
     */
    protected function getEncryptionInfo(): array
    {
        return [
            'algorithm' => 'AES-256',
            'key_version' => config('app.encryption_key_version', '1'),
            'compliant' => true,
            'standard' => 'PDPA Compliant'
        ];
    }

    /**
     * Log encryption/decryption operations for audit.
     */
    protected function logEncryptionOperation($operation, $attribute, $modelId): void
    {
        \Log::info("Data {$operation}", [
            'model' => static::class,
            'model_id' => $modelId,
            'attribute' => $attribute,
            'timestamp' => now(),
            'encryption_info' => $this->getEncryptionInfo()
        ]);
    }
}
