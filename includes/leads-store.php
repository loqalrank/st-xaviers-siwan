<?php
require_once __DIR__ . '/storage.php';

/**
 * Lead storage for admission and contact form submissions.
 */

function leads_path(): string
{
    return sxhs_data_file('leads.json');
}

/**
 * @return array<int, array<string, mixed>>
 */
function leads_all(): array
{
    $path = leads_path();
    if (!is_file($path)) {
        return [];
    }

    $raw = @file_get_contents($path);
    $decoded = $raw ? json_decode($raw, true) : null;

    return is_array($decoded) ? array_values($decoded) : [];
}

function leads_write(array $leads): bool
{
    $dir = dirname(leads_path());
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        return false;
    }

    $json = json_encode(array_values($leads), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    $tmp = leads_path() . '.tmp';
    if (@file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }

    return @rename($tmp, leads_path());
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

function enquiry_rate_limited(string $ip, int $maxPerWindow = 3, int $window = 600): bool
{
    $file = sxhs_data_file('rate.json');
    $now = time();
    $data = [];

    if (is_file($file)) {
        $decoded = json_decode((string) @file_get_contents($file), true);
        if (is_array($decoded)) {
            $data = $decoded;
        }
    }

    foreach ($data as $key => $times) {
        $fresh = [];
        foreach ((array) $times as $time) {
            if (is_numeric($time) && (int) $time > $now - 86400) {
                $fresh[] = (int) $time;
            }
        }
        if ($fresh !== []) {
            $data[$key] = $fresh;
        } else {
            unset($data[$key]);
        }
    }

    if (count($data) > 500) {
        $data = array_slice($data, -500, null, true);
    }

    $key = hash('sha256', $ip);
    $recent = [];
    if (isset($data[$key])) {
        foreach ($data[$key] as $time) {
            if ($time > $now - $window) {
                $recent[] = $time;
            }
        }
    }

    $limited = count($recent) >= $maxPerWindow;

    if (!$limited) {
        $recent[] = $now;
        $data[$key] = $recent;
    }

    $json = json_encode($data, JSON_UNESCAPED_SLASHES);
    $tmp = $file . '.tmp';
    if ($json !== false && @file_put_contents($tmp, $json, LOCK_EX) !== false) {
        @rename($tmp, $file);
    }

    return $limited;
}
