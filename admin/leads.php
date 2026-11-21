<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/leads-store.php';

admin_require_login();

$statuses = lead_statuses();
$leads = leads_all();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';
    $leadId = isset($_POST['id']) ? (string) $_POST['id'] : '';

    if ($op === 'status') {
        $status = isset($_POST['status']) ? (string) $_POST['status'] : '';
        if (isset($statuses[$status]) && leads_update_status($leadId, $status)) {
            admin_flash('success', 'Lead status updated.');
        } else {
            admin_flash('error', 'Could not update the lead status.');
        }
        admin_redirect('leads.php');
    }

    if ($op === 'delete') {
        if (leads_delete($leadId)) {
            admin_flash('success', 'Lead deleted.');
        } else {
            admin_flash('error', 'Could not delete the lead.');
        }
        admin_redirect('leads.php');
    }
}

$viewId = isset($_GET['view']) ? (string) $_GET['view'] : '';
if ($viewId !== '') {
    $lead = null;
    foreach ($leads as $candidate) {
        if (isset($candidate['id']) && $candidate['id'] === $viewId) {
            $lead = $candidate;
            break;
        }
    }

    if (!$lead) {
        admin_flash('error', 'Lead not found.');
        admin_redirect('leads.php');
    }

    admin_header('Lead details', 'leads');
    ?>
    <div class="admin-actions" style="margin-bottom:16px">
        <a class="admin-btn admin-btn-light" href="leads.php">Back to leads</a>
    </div>
    <div class="admin-card">
        <table class="admin-table">
            <tbody>
                <tr><th>Received</th><td><?php echo e(date('d M Y, h:i A', strtotime((string) ($lead['created_at'] ?? 'now')))); ?></td></tr>
                <tr><th>Type</th><td><?php echo e(($lead['type'] ?? 'admission') === 'contact' ? 'Contact message' : 'Admission enquiry'); ?></td></tr>
                <tr><th>Name</th><td><?php echo e($lead['name'] ?? ''); ?></td></tr>
                <tr><th>Phone</th><td><a href="tel:<?php echo e($lead['phone'] ?? ''); ?>"><?php echo e($lead['phone'] ?? ''); ?></a></td></tr>
                <tr><th>Email</th><td><a href="mailto:<?php echo e($lead['email'] ?? ''); ?>"><?php echo e($lead['email'] ?? ''); ?></a></td></tr>
                <?php if (($lead['type'] ?? '') !== 'contact'): ?>
                    <tr><th>Student</th><td><?php echo e($lead['student'] ?? ''); ?></td></tr>
                    <tr><th>Class</th><td><?php echo e($lead['class'] ?? ''); ?></td></tr>
                <?php else: ?>
                    <tr><th>Subject</th><td><?php echo e($lead['subject'] ?? ''); ?></td></tr>
                <?php endif; ?>
                <tr><th>Address</th><td><?php echo nl2br(e($lead['address'] ?? '')); ?></td></tr>
                <tr><th>Message</th><td><?php echo nl2br(e($lead['message'] ?? '')); ?></td></tr>
                <tr><th>Consent</th><td><?php echo e(($lead['consent'] ?? '') === 'yes' ? 'Given' : 'Not given'); ?></td></tr>
                <tr><th>Email delivery</th><td><?php echo !empty($lead['email_sent']) ? 'Sent' : 'Failed / not sent'; ?></td></tr>
                <tr><th>Status</th><td>
                    <form method="post" action="leads.php" class="admin-actions">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="op" value="status">
                        <input type="hidden" name="id" value="<?php echo e($lead['id']); ?>">
                        <select name="status" style="max-width:180px">
                            <?php foreach ($statuses as $key => $label): ?>
                                <option value="<?php echo e($key); ?>"<?php echo ($lead['status'] ?? 'new') === $key ? ' selected' : ''; ?>><?php echo e($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="admin-btn admin-btn-sm">Update status</button>
                    </form>
                </td></tr>
            </tbody>
        </table>
    </div>
    <?php
    admin_footer();
    exit;
}

$filterType   = isset($_GET['type']) ? (string) $_GET['type'] : '';
$filterStatus = isset($_GET['status']) ? (string) $_GET['status'] : '';

$visible = [];
foreach ($leads as $lead) {
    if ($filterType !== '' && ($lead['type'] ?? 'admission') !== $filterType) {
        continue;
    }
    if ($filterStatus !== '' && ($lead['status'] ?? 'new') !== $filterStatus) {
        continue;
    }
    $visible[] = $lead;
}

admin_header('Leads', 'leads');
?>
<div class="admin-card">
    <div class="admin-actions" style="margin-bottom:14px">
        <a class="admin-btn admin-btn-sm <?php echo $filterType === '' ? '' : 'admin-btn-light'; ?>" href="leads.php">All types</a>
        <a class="admin-btn admin-btn-sm <?php echo $filterType === 'admission' ? '' : 'admin-btn-light'; ?>" href="leads.php?type=admission">Admission</a>
        <a class="admin-btn admin-btn-sm <?php echo $filterType === 'contact' ? '' : 'admin-btn-light'; ?>" href="leads.php?type=contact">Contact</a>
        <span style="width:14px"></span>
        <a class="admin-btn admin-btn-sm <?php echo $filterStatus === '' ? '' : 'admin-btn-light'; ?>" href="leads.php">All statuses</a>
        <?php foreach ($statuses as $key => $label): ?>
            <a class="admin-btn admin-btn-sm <?php echo $filterStatus === $key ? '' : 'admin-btn-light'; ?>" href="leads.php?status=<?php echo e($key); ?>"><?php echo e($label); ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (!$visible): ?>
        <p>No leads found.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Received</th><th>Type</th><th>Name</th><th>Phone</th><th>Class / Subject</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($visible as $lead): ?>
                        <?php
                        $typeLabel = ($lead['type'] ?? 'admission') === 'contact' ? 'Contact' : 'Admission';
                        $detail = ($lead['type'] ?? 'admission') === 'contact' ? ($lead['subject'] ?? '') : ($lead['class'] ?? '');
                        ?>
                        <tr>
                            <td><?php echo e(date('d M Y', strtotime((string) ($lead['created_at'] ?? 'now')))); ?></td>
                            <td><?php echo e($typeLabel); ?></td>
                            <td><?php echo e($lead['name'] ?? ''); ?></td>
                            <td><?php echo e($lead['phone'] ?? ''); ?></td>
                            <td><?php echo e($detail); ?></td>
                            <td>
                                <form method="post" action="leads.php" class="admin-actions">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="op" value="status">
                                    <input type="hidden" name="id" value="<?php echo e($lead['id'] ?? ''); ?>">
                                    <select name="status">
                                        <?php foreach ($statuses as $key => $label): ?>
                                            <option value="<?php echo e($key); ?>"<?php echo ($lead['status'] ?? 'new') === $key ? ' selected' : ''; ?>><?php echo e($label); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="admin-btn admin-btn-sm admin-btn-light">Save</button>
                                </form>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm" href="leads.php?view=<?php echo e($lead['id'] ?? ''); ?>">View</a>
                                    <form method="post" action="leads.php" onsubmit="return confirm('Delete this lead?');">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="op" value="delete">
                                        <input type="hidden" name="id" value="<?php echo e($lead['id'] ?? ''); ?>">
                                        <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php
admin_footer();
