
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel">
  <div class="modal-dialog modal-xl modal-dialog-scrollable custom-modal-width">
    <div class="modal-content shadow-lg rounded-4" id="currentModalContent">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewModalLabel"><i class="bi bi-eye-fill me-2"></i>Issuance Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBodyContent">
        <!-- Dynamic content will be injected here -->
      </div>
    </div>
  </div>
</div>

<!-- Second Modal -->
<div class="modal fade" id="nextModal" tabindex="-1">
  <div class="modal-dialog modal-xl custom-modal-width">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title">Property Accountability Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="modalConfirmContent" style="max-height: 70vh; overflow-y: auto;">
        <!-- Header Info -->
        <div class="text-center mb-4">
          <div class="mt-2 text-end"><strong>DATE:</strong> <span id="receipt-date"></span></div>
        </div>

        <!-- Item Table -->
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
            <tbody id="receipt-items-body">
              <!-- Dynamic item rows will be inserted here -->
            </tbody>
          </table>
        </div>

        <p id="acknowledgment-container" class="mt-3"></p>

        <!-- Acknowledgment -->
        <p class="p-3" id="acknowledgment-text">
          <!-- Will be filled dynamically -->
        </p>
        

        <!-- Signature -->
        <div class="row mt-5">
          <div class="col-md-6 offset-md-6">
            <p><strong>Received by:</strong></p>
            <div class="border-bottom mb-2" style="height: 2em;" id="signature-name"></div>
            <div class="small text-muted mb-3">Printed Name & Signature</div>
            <div class="border-bottom" style="height: 2em;" id="signature-role"></div>
            <div class="small text-muted">Designation</div>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer bg-light d-flex justify-content-between" style="position: sticky; bottom: 0; z-index: 1055;">
        <div>
          <button type="button" class="btn btn-secondary" id="backBtn">Back</button>
        </div>
        <div>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
function loadReceiptData() {
  const receiptDate = new Date().toLocaleDateString('en-US', {
    year: 'numeric', month: 'long', day: 'numeric'
  });
  document.getElementById('receipt-date').innerText = receiptDate;

  const issuanceData = JSON.parse(localStorage.getItem('selectedIssuance')) || {};
  console.log("Selected Issuance Data:", issuanceData);

  const items = issuanceData.items || [];
  const department = issuanceData.departmentName || '______';
  const receivedBy = {
    name: issuanceData.receivedBy || '',
    designation: department
  };

  const tbody = document.getElementById('receipt-items-body');
  tbody.innerHTML = '';

  let totalValue = 0;

  // Group items by itemNo
  const groupedItems = {};
  items.forEach(item => {
    const key = item.itemNo;
    if (!groupedItems[key]) {
      groupedItems[key] = {
        ...item,
        quantity: 1
      };
    } else {
      groupedItems[key].quantity += 1;
    }
  });

  console.log('Grouped Items by itemNo:', groupedItems);

  // Render each grouped item
  Object.values(groupedItems).forEach(item => {
    const quantity = item.quantity;
    const unitValue = parseFloat(item.unitValue?.replace(/,/g, '')) || 0;
    const computedTotal = unitValue * quantity;
    totalValue += computedTotal;

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="text-center align-middle">${quantity}</td>
      <td class="text-center align-middle">${item.unit || ''}</td>
      <td class="text-start">${item.description}</td>
      <td>${item.dateAcquired || ''}</td>
      <td>${item.unitValue || ''}</td>
      <td>${computedTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
    `;

    tbody.appendChild(tr);
  });

  // Add totals row
  const totalRow = `
    <tr>
      <td colspan="4" class="text-end fw-bold">TOTAL</td>
      <td class="fw-bold"></td>
      <td class="fw-bold">${totalValue.toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
    </tr>
    <tr>
      <td colspan="6" class="text-center fst-italic">* Nothing follows *</td>
    </tr>
  `;
  tbody.insertAdjacentHTML('beforeend', totalRow);

  // Acknowledgment with checkbox
  const acknowledgmentHTML = `
    <div class="form-check text-start mt-4">
      <input class="form-check-input" type="checkbox" id="acknowledgeCheckbox">
      <label class="form-check-label" for="acknowledgeCheckbox">
        I acknowledge to have received from <strong>Finance Office</strong>, the following property items for which I am responsible and will be used in the office/department of <strong>${department}</strong>.
      </label>
    </div>
  `;
  document.getElementById('acknowledgment-container').innerHTML = acknowledgmentHTML;

  // Signature section
  document.getElementById('signature-name').innerText = receivedBy.name;
  document.getElementById('signature-role').innerText = receivedBy.designation;
}

// Trigger when modal is shown
const nextModalEl = document.getElementById('nextModal');
nextModalEl.addEventListener('shown.bs.modal', loadReceiptData);
</script>




<script>
  document.addEventListener("DOMContentLoaded", function () {
    const confirmBtn = document.getElementById("confirmBtn");

    confirmBtn.addEventListener("click", function () {
      Swal.fire({
        title: "Are you sure?",
        text: "You are about to confirm the Property Accountability Receipt.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, confirm it!",
        cancelButtonText: "No, cancel",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Build printable HTML content
          const printContent = `
            <html>
              <head>
                <title>Property Accountability Receipt</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                <style>
                  body { font-family: Arial, sans-serif; padding: 30px; }
                  .header-logo { width: 100px; height: auto; }
                  .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
                  .text-center h5, .text-center h6 { margin: 0; }
                  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                  th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                  .signature-section { margin-top: 100px; }
                  .signature-box { width: 300px; }
                  .border-bottom { border-bottom: 1px solid #000; height: 40px; margin-bottom: 5px; }
                </style>
              </head>
              <body>
                <div class="header">
                  <img src="image/dwcl-logo.png" alt="Logo" class="header-logo">
                  <div class="text-center flex-grow-1">
                    <h5>DIVINE WORD COLLEGE OF LEGAZPI</h5>
                    <h6>LEGAZPI CITY</h6>
                    <h5 class="fw-bold mt-2">PROPERTY ACCOUNTABILITY RECEIPT</h5>
                  </div>
                </div>

                <div class="text-end mb-4">
                  <strong>DATE:</strong> ${new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  })}
                </div>

                <p>
                  I acknowledge to have received from <strong>Finance Office</strong>, the following property items for which I am responsible and will be used in the office/department of <strong>ACCOUNTING OFFICE</strong>.
                </p>

                <table>
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
                    <tr>
                      <td colspan="2">1</td>
                      <td>
                        <strong>System Unit:</strong> Acer - Aspire TC-1770<br>
                        sn: DTBK7SPOO4320006E29600<br>
                        CPU: Intel core i7-13700: 8gb DDR4<br>
                        1TB HDD, 256GB SSD
                      </td>
                      <td>08/09/2024</td>
                      <td></td>
                      <td>66,000.00</td>
                    </tr>
                    <tr>
                      <td colspan="2">1</td>
                      <td>
                        <strong>Monitor:</strong> Acer LCD<br>
                        model no: KA242HYL<br>
                        sn: MMTPBSPOO22222B9C44218
                      </td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <div class="signature-section">
                  <div class="signature-box">
                    <p><strong>Received by:</strong></p>
                    <div class="border-bottom"></div>
                    <p class="mb-0"><small>Printed Name & Signature</small></p>
                    <div class="border-bottom" style="height: 30px;"></div>
                    <p><small>Designation</small></p>
                  </div>
                </div>
              </body>
            </html>
          `;

          // Create a hidden iframe to print from the same tab
          const iframe = document.createElement("iframe");
          iframe.style.position = "fixed";
          iframe.style.right = "0";
          iframe.style.bottom = "0";
          iframe.style.width = "0";
          iframe.style.height = "0";
          iframe.style.border = "0";
          document.body.appendChild(iframe);

          const doc = iframe.contentWindow.document;
          doc.open();
          doc.write(printContent);
          doc.close();

          iframe.onload = () => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();

            setTimeout(() => {
              document.body.removeChild(iframe); // Clean up
            }, 1000);
          };
        }
      });
    });
  });
</script>
