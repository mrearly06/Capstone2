<?php
include 'connection.php';

$issuanceReviewNo = $_GET['id'];

$query = "SELECT 
            i.quantity,
            i.description,
            i.dateAcquired,
            i.unitValue
        FROM issuance_review ir
        LEFT JOIN item_instance ii ON ir.itemInstanceID = ii.itemInstanceID
        LEFT JOIN item i ON ii.itemNo = i.itemNo
        WHERE ir.issuanceReviewNo = '$issuanceReviewNo'";

$result = $conn->query($query);
$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
}

$dateToday = strtoupper(date("F d, Y"));

// Start output buffering
ob_start();
?>

<div class="text-center mb-4">
  <div class="mt-2 text-end"><strong>DATE:</strong> <?= $dateToday ?></div>
</div>

<div class="table-responsive border rounded-3 shadow-sm">
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr>
        <th colspan="2">QTY.</th>
        <th>ITEM DESCRIPTION</th>
        <th>Date Acquired</th>
        <th>Unit Value</th>
        <th>Total Value</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($rows) > 0): ?>
        <?php foreach ($rows as $row): 
          $quantity = (int) $row['quantity'];
          $unitValue = (float) $row['unitValue'];
          $totalValue = $quantity * $unitValue;
        ?>
          <tr>
            <td colspan="2"><?= $quantity ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['dateAcquired']) ?></td>
            <td>₱<?= number_format($unitValue, 2) ?></td>
            <td>₱<?= number_format($totalValue, 2) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center fst-italic">* Nothing follows *</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<p class="p-3">
  I acknowledge to have received from <strong>Finance Office</strong>, the following property items for which I am responsible and will be used in the office/department of <strong>ACCOUNTING OFFICE</strong>.
</p>

<div class="row mt-5">
  <div class="col-md-6 offset-md-6">
    <p><strong>Received by:</strong></p>
    <div class="border-bottom mb-2" style="height: 2em;"></div>
    <div class="small text-muted">Printed Name & Signature</div>
    <div class="border-bottom" style="height: 2em;"></div>
    <div class="small text-muted">Designation</div>
  </div>
</div>

<?php
$content = ob_get_clean();
echo json_encode(['html' => $content]);
?>
