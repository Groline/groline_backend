<?php

namespace App\Services;

use App\Models\Set;
use Chargily\ChargilyPay\ChargilyPay;
use Chargily\ChargilyPay\Auth\Credentials;

class ChargilyService
{
    private ?ChargilyPay $chargily = null;

    public function __construct()
    {
        if ($this->isEnabled()) {
            $this->chargily = new ChargilyPay(new Credentials(Set::chargily_credentials()));
        }
    }

    /**
     * Check if Chargily is fully configured and enabled.
     */
    public function isEnabled(): bool
    {
        $enabled = Set::where('name', 'chargily_enabled')->value('value');

        if (!$enabled) {
            return false;
        }

        $credentials = Set::chargily_credentials();

        return !empty($credentials['mode'])
            && !empty($credentials['public'])
            && !empty($credentials['secret']);
    }

    /**
     * Get the ChargilyPay instance, or null if not available.
     */
    public function instance(): ?ChargilyPay
    {
        return $this->chargily;
    }

    /**
     * Create a Chargily customer.
     * Returns customer ID string on success, null if Chargily is disabled.
     */
    public function createCustomer(string $name, string $email, string $phone): ?string
    {
        if (!$this->chargily) {
            return null;
        }

        $customer = $this->chargily->customers()->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);

        return $customer->getId();
    }

    /**
     * Get a checkout by its ID.
     * Returns the checkout object on success, null if Chargily is disabled.
     */
    public function getCheckout(string $checkoutId)
    {
        if (!$this->chargily) {
            return null;
        }

        return $this->chargily->checkouts()->get($checkoutId);
    }
}
