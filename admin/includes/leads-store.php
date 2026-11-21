<?php
/**
 * Lead storage used by the admin panel.
 * Self-contained: reads/writes <admin>/data/leads.json via the admin
 * storage layer. The public enquiry forms write to the same file when
 * the site's storage layer resolves to <admin>/data.
 */

require_once __DIR__ . '/storage.php';

/**
 * @return array<int, array<string, mixed>>
 */
function leads_all(): array
{
    $path = admin_data_file('leads.json');
    if (!is_file($path)) {
        return [];
    }

    $raw = @file_get_contents($path);
    $decoded = $raw ? json_decode($raw, true) : null;

    return is_array($decoded) ? array_values($decoded) : [];
}

function leads_write(array $leads): bool
{
    $json = json_encode(array_values($leads), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    $path = admin_data_file('leads.json');
    $tmp  = $path . '.tmp';
    if (@file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }

    return @rename($tmp, $path);
}

function leads_add(array $lead): bool
{
    $leads = leads_all();
    array_unshift($leads, $lead);

    if (count($leads) > 2000) {
        $leads = array_slice($leads, 0, 2000);
    }

    return leads_write($leads);
}

function leads_update_status(string $id, string $status): bool
{
    $leads = leads_all();
    $changed = false;

    foreach ($leads as $index => $lead) {
        if (isset($lead['id']) && $lead['id'] === $id) {
            $leads[$index]['status'] = $status;
            $leads[$index]['updated_at'] = date('c');
            $changed = true;
            break;
        }
    }

    return $changed ? leads_write($leads) : false;
}

function leads_delete(string $id): bool
{
    $leads = leads_all();
    $remaining = [];

    foreach ($leads as $lead) {
        if (!isset($lead['id']) || $lead['id'] !== $id) {
            $remaining[] = $lead;
        }
    }

    if (count($remaining) === count($leads)) {
        return false;
    }

    return leads_write($remaining);
}

function lead_statuses(): array
{
    return [
        'new'       => 'New',
        'contacted' => 'Contacted',
        'follow_up' => 'Follow Up',
        'admitted'  => 'Admitted',
        'closed'    => 'Closed',
    ];
}

function lead_status_label(string $status): string
{
    $statuses = lead_statuses();

    return isset($statuses[$status]) ? $statuses[$status] : 'New';
}
