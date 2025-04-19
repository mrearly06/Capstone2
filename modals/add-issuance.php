<!-- Large Modal -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Select Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="searchItem" class="form-control" placeholder="Search for an item...">
                </div>

                <!-- Table for Displaying Items -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>Select</th>
                                <th>Image</th>
                                <th>Item Instance Code</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th style="display: none;">Quantity</th>
                                <th>Date Acquired</th>
                                <th style="display: none;">Unit Price</th>
                                <th style="display: none;">Amount</th>
                                <th>Item Instance id</th>
                                <th>Item No</th>
                            </tr>
                        </thead>
                        <tbody id="itemTableBodyModal">
                            <!-- Fetched Items Will Be Inserted Here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmSelection">Confirm Selection</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("largeModal");

    // Fetch items when the modal is opened
    modal.addEventListener("shown.bs.modal", function () {
        fetchItems();
    });

    // Function to Fetch Items from the Database

function fetchItems() {
    fetch("backend/fetch-items-to-issue.php")
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("itemTableBodyModal");
            tableBody.innerHTML = "";

            let storedData = JSON.parse(localStorage.getItem("selectedItems")) || [];
            console.log("Selected Items eugfu: ", storedData);

            let selectedRows = [];
            let otherRows = [];

            data.forEach(item => {
                let isChecked = storedData.some(data => data.itemInstanceCode === item.itemInstanceCode);

                let row = document.createElement("tr");
                row.classList.add("text-center");
                row.innerHTML = `
                    <td>
                        <input type="checkbox" class="item-checkbox" value="${item.itemInstanceCode}" 
                            data-item="${item.itemName}" 
                            data-item-instance-id="${item.itemInstanceID}"
                            data-description="${item.description}" 
                            data-quantity="${item.quantity}" 
                            data-date-acquired="${item.dateAcquired}"
                            data-unit-value="${item.unitValue}" 
                            data-total-value="${item.totalValue}"
                            data-image="uploads/asset_img/${item.image}"
                            data-item-no="${item.itemNo}"
                            ${isChecked ? "checked" : ""}>
                    </td>
                    <td>
                        <img src="uploads/asset_img/${item.image}" alt="Item Image" class="img-thumbnail border-0" width="50">
                    </td>
                    <td>${item.itemInstanceCode}</td>
                    <td>${item.itemName}</td>
                    <td>${item.description}</td>
                    <td style="display: none;">${item.quantity}</td>
                    <td>${item.dateAcquired}</td>
                    <td style="display: none;">${item.unitValue}</td>
                    <td style="display: none;">${item.totalValue}</td>
                    <td>${item.itemInstanceID}</td>
                    <td>${item.itemNo}</td>

                `;

                if (isChecked) {
                    selectedRows.push(row);
                } else {
                    otherRows.push(row);
                }
            });

            // Append selected rows first, then other rows
            selectedRows.forEach(row => tableBody.appendChild(row));
            otherRows.forEach(row => tableBody.appendChild(row));

            attachCheckboxListeners();
        })
        .catch(error => console.error("Error fetching items:", error));
}


    // Search Functionality
    document.getElementById("searchItem").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#itemTableBodyModal tr");
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
});




// confirm selection 
document.addEventListener("DOMContentLoaded", function () {
    let confirmButton = document.getElementById("confirmSelection");

    confirmButton.addEventListener("click", function () {
        let selectedItems = [];
        let checkboxes = document.querySelectorAll(".item-checkbox:checked");

        checkboxes.forEach(checkbox => {
            selectedItems.push({
                itemInstanceCode: checkbox.value,
                itemInstanceID: checkbox.dataset.itemInstanceId, // ✅ FIXED
                itemName: checkbox.dataset.item,
                description: checkbox.dataset.description,
                quantity: checkbox.dataset.quantity,
                dateAcquired: checkbox.dataset.dateAcquired,
                unitValue: checkbox.dataset.unitValue,
                totalValue: checkbox.dataset.totalValue,
                image: checkbox.dataset.image,
                itemNo: checkbox.dataset.itemNo
            });
        });

            // Log the selected items
            console.log("Selected Items: ", selectedItems);

        // Save selected items in localStorage
        localStorage.setItem("selectedItems", JSON.stringify(selectedItems));

        // Close the modal
        let modal = bootstrap.Modal.getInstance(document.getElementById("largeModal"));
        modal.hide();

        // Populate the table
        populateItemTable();
    });

});

document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("largeModal");

    // Fetch valid items from the database
    function fetchValidItemsFromDB() {
        fetch("backend/fetch-deleted-items.php")
            .then(response => response.json())
            .then(validItems => {
                let storedData = JSON.parse(localStorage.getItem("selectedItems")) || [];

                // Remove items from localStorage that no longer exist in the database
                let updatedStoredData = storedData.filter(item => validItems.includes(item.itemInstanceCode));

                localStorage.setItem("selectedItems", JSON.stringify(updatedStoredData));
            })
            .catch(error => console.error("Error fetching valid items:", error));
    }

    // Call the function when modal opens (or when page loads)
    modal.addEventListener("shown.bs.modal", fetchValidItemsFromDB);
});

</script>

