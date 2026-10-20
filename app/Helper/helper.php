<?php

use Illuminate\Support\Str;

/**
 * Convert a limit value to a human-readable string.
 *
 * If the input is '-1', it returns 'Unlimited'.
 * Otherwise, it returns the original value.
 *
 * @param string $value
 * @return string
 */
function displayLimit(string $value): string {
    return $value == '-1' ? 'Unlimited' : $value;
};

/**
 * Return an icon class based on a numeric value.
 *
 * If the value is truthy (non-zero), returns the first icon.
 * Otherwise, returns the second icon.
 *
 * @param int $value
 * @param string $firstIcon
 * @param string $secondIcon
 * @return string
 */
function displayIcon(int $value, string $firstIcon, string $secondIcon): string {
    return $value ? $firstIcon : $secondIcon;
};

/**
 * Format a feature limit into a human-readable string.
 *
 * Converts numeric plan limits into readable phrases like:
 * - "Unlimited Photos Allowed"
 * - "No Video per Property Allowed"
 * - "20 Photos per Property Allowed"
 *
 * @param string $value
 * @param string $label
 * @param string|null $extra
 * @return string
 */
function formatLimit(string $value, string $label, string $extra = null): string {
    if ($value == '-1') return 'Unlimited' . ' ' . Str::plural($label) . " $extra" . ' ' . 'Allowed';
    if ($value == '0') return 'No' . ' ' . $label . " $extra" . ' ' . 'Allowed';
    return $value . ' ' . Str::plural($label, $value) . " $extra" . ' ' . 'Allowed';
};
