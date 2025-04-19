
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

      <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">


      </div>

      <!-- Modal Footer (Fixed Position) -->
      <div class="modal-footer bg-light d-flex justify-content-between" style="position: sticky; bottom: 0; z-index: 1055;">
        <!-- Left side: Back Button -->
        <div>
          <button type="button" class="btn btn-secondary" id="backBtn">Back</button>
        </div>

        <!-- Right side: Close & Confirm Buttons -->
        <div>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const storedData = JSON.parse(localStorage.getItem('fetchedData'));
console.log("📦 Retrieved from localStorage:", storedData);
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const viewBtns = document.querySelectorAll('.viewBtn');

  viewBtns.forEach(btn => {
    btn.addEventListener('click', async function () {
      const issuanceId = this.getAttribute('data-id');

      try {
        const response = await fetch(`backend/view-incoming-issuance-details.php?id=${issuanceId}`);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const data = await response.json();

        if (data.length === 0) {
          document.getElementById('modalBodyContent').innerHTML = "<p>No data found.</p>";
        } else {
          const header = data[0];
          const itemRows = data;

          let headerHTML = `
          <div class="row mb-4">
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item"><strong>Issuance No:</strong> ${header.issuanceReviewNo}</li>
                <li class="list-group-item"><strong>Date:</strong> ${header.date}</li>
                <li class="list-group-item"><strong>Time:</strong> ${header.time}</li>
                <li class="list-group-item"><strong>Quantity:</strong> ${itemRows.length}</li>
                <li class="list-group-item"><strong>Issued By:</strong> ${header.issuedBy}</li>
                <li class="list-group-item"><strong>Issued By Date:</strong> ${header.issuedByDate}</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item"><strong>Received By:</strong> ${header.receivedBy}</li>
                <li class="list-group-item"><strong>Received By Date:</strong> ${header.receivedByDate}</li>
                <li class="list-group-item"><strong>Posted By:</strong> ${header.postedBy}</li>
                <li class="list-group-item"><strong>Posted By Date:</strong> ${header.postedByDate}</li>
                <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-success">${header.status}</span></li>
                <li class="list-group-item"><strong>Department:</strong> ${header.departmentName}</li>
              </ul>
            </div>
          </div>`;

          let tableHTML = `
          <div class="table-responsive border rounded-3 shadow-sm">
            <table class="table table-hover align-middle text-center">
              <thead class="table-primary">
                <tr>
                  <th scope="col">Item Image</th>
                  <th scope="col">Item Description</th>
                  <th scope="col">Reference No.</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col">Item Instance Code</th>
                </tr>
              </thead>
              <tbody>`;

          itemRows.forEach(row => {
            const imgSrc = row.image ? `uploads/asset_img/${row.image}` : 'uploads/asset_img/image/sample-item.jpg';
            tableHTML += `
              <tr>
                <td><img src="${imgSrc}" alt="Item Image" class="img-thumbnail" style="max-width: 80px;"></td>
                <td>${row.description}</td>
                <td>${row.refNo}</td>
                <td>₱${parseFloat(row.unitValue).toFixed(2)}</td>
                <td>${row.itemInstanceCode}</td>
              </tr>`;
          });

          tableHTML += `</tbody></table></div>`;

          let footerHTML = `
            <div class="modal-footer bg-light fixed-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary proceedBtn" data-issuance-id="${header.issuanceReviewNo}">Proceed</button>
            </div>`;

          document.querySelector('#modalBodyContent').innerHTML = headerHTML + tableHTML + footerHTML;
        }

        const nextModal = new bootstrap.Modal(document.getElementById('viewModal'));
        nextModal.show();

      } catch (error) {
        console.error('Error fetching modal data:', error);
        document.getElementById('modalBodyContent').innerHTML = `<div class="alert alert-danger">Failed to load content.</div>`;
      }
    });
  });
});
</script>
