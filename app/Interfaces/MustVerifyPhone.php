<?php


namespace App\Interfaces;


interface MustVerifyPhone
{
    /**
     * Determine if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPhone();

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified();

    /**
     * Send the email verification notification.
     *
     * @return mixed
     */
    public function sendPhoneVerificationNotification();

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification();
}
