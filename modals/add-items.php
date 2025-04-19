<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="backend/add-item-query.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="itemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Enter item name">
                        </div>
                        <div class="col-md-3" id="itemQuantityContainer">
                            <label for="itemQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="itemQuantity" name="itemQuantity" placeholder="Enter quantity" oninput="calculateTotalValue()" min="1" value="1">
                        </div>
                        <div class="col-md-3" id="itemCodeContainer">
                                <label for="itemCode" class="form-label">Item Code</label>
                                <input type="text" id="itemCode" class="form-control" name="itemCode" placeholder="Auto-generated Item Code">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="itemDate" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control" id="itemDate" name="itemDate">
                        </div>
                        <div class="col-md-4">
                            <label for="itemValue" class="form-label">Unit Value</label>
                            <input type="text" class="form-control" id="itemValue" name="itemValue" placeholder="Enter unit value" oninput="calculateTotalValue()">
                        </div>
                        <div class="col-md-4">
                            <label for="itemDescription" class="form-label">Item Description</label>
                            <textarea class="form-control" id="itemDescription" name="itemDescription" rows="3" placeholder="Enter item description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="totalValue" class="form-label">Total Value</label>
                            <input type="text" class="form-control" id="totalValue" name="totalValue" placeholder="Enter total value">
                        </div>
                        <div class="col-md-4">
                            <label for="itemImage" class="form-label">Item Image</label>
                            <input type="file" class="form-control" id="itemImage" name="itemImage" accept="image/*" onchange="previewImage(event)" required>
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option disabled selected>Select a category</option>
                                <option value="Office Supplies">Office Supplies</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Computers and IT Equipment">Computers and IT Equipment</option>
                                <option value="Laboratory Equipment">Laboratory Equipment</option>
                                <option value="Audio-Visual Equipment">Audio-Visual Equipment</option>
                                <option value="Classroom Materials">Classroom Materials</option>
                                <option value="Sports & Physical Education Equipment">Sports & Physical Education Equipment</option>
                                <option value="Maintenance & Janitorial Supplies">Maintenance & Janitorial Supplies</option>
                                <option value="Library Resources">Library Resources</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                
                        <div class="col-md-12">
                            <img id="imagePreview" src="" alt="Image Preview" class="img-fluid mt-2 mx-auto" style="display:none; max-height: 200px;">
                        </div>
                    </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = '';
        imagePreview.style.display = 'none';
    }
}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var addItemModal = document.getElementById('addItemModal');

    addItemModal.addEventListener('show.bs.modal', function () {
        // Fetch the new itemCode from the server when the modal opens
        fetch('backend/get-new-item-code.php')
            .then(response => response.text())
            .then(data => {
                // Set the itemCode field with the generated value
                document.getElementById('itemCode').value = data;
            })
            .catch(error => console.error('Error fetching new item code:', error));
    });
});
</script>

<script>
function calculateTotalValue() {
    const quantity = document.getElementById('itemQuantity').value;
    const unitValue = document.getElementById('itemValue').value;
    const totalValue = document.getElementById('totalValue');

    // Calculate the total value
    const total = parseFloat(quantity) * parseFloat(unitValue);

    // Update the total value input field
    totalValue.value = isNaN(total) ? '' : total.toFixed(2);

 
   
}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initial generation for single item code on page load
    generateItemCodeInputs(1);

    // Listen for changes in the item quantity input
    const quantityInput = document.getElementById('itemQuantity');
    quantityInput.addEventListener('input', function() {
        const quantity = parseInt(this.value) || 1; // Default to 1 if the value is invalid
        generateItemCodeInputs(quantity);
    });
});

function generateItemCodeInputs(quantity) {
    const itemCodeContainer = document.getElementById('itemCodeContainer');

    // Clear the container before adding new inputs
    itemCodeContainer.innerHTML = '';

    // If quantity is empty, default it to 1
    if (!quantity || isNaN(parseInt(quantity)) || parseInt(quantity) <= 0) {
        quantity = 1; // Default to 1 if invalid
    }

    // Fetch new item codes based on the specified quantity
    fetch(`backend/get-new-item-code.php?quantity=${quantity}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched item codes:', data); // Log the fetched item codes
            
            // Check if we got enough item codes
            if (data.length < quantity) {
                console.error('Not enough unique item codes returned.');
                return; // Handle error as needed
            }

            // Generate the input fields based on the quantity
            for (let i = 0; i < quantity; i++) {
                const inputGroup = document.createElement('div');
                inputGroup.className = 'mb-3';

                const inputLabel = document.createElement('label');
                inputLabel.className = 'form-label';
                inputLabel.innerText = `Item Code ${i + 1}`;

                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.className = 'form-control';
                inputField.name = `itemCode[]`; // Use an array for itemCode names
                inputField.placeholder = 'Auto-generated Item Code';
                inputField.id = `itemCode${i}`;
                inputField.value = data[i] || ''; // Set the fetched unique item code, or empty string

                // Check each input field for duplicates right after creation
                inputField.addEventListener('input', function() {
                    checkItemCode(this); // Validate the item code
                });

                // Append label and input to the container
                inputGroup.appendChild(inputLabel);
                inputGroup.appendChild(inputField);
                itemCodeContainer.appendChild(inputGroup);
            }

            // Check the generated item codes for duplicates
            itemCodeContainer.querySelectorAll('input[name="itemCode[]"]').forEach(inputField => {
                checkItemCode(inputField);
            });
        })
        .catch(error => console.error('Error fetching new item codes:', error));
}

function checkItemCode(inputField) {
    const itemCode = inputField.value.trim();

    // Clear any existing alert message if the input is empty
    if (itemCode === '') {
        clearAlertMessage(inputField);
        return;
    }

    // Perform AJAX request to check if the item code already exists
    fetch('backend/check-item-code.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'itemCode': itemCode
        })
    })
    .then(response => response.json())
    .then(data => {
        // Check if the item code already exists
        if (data.exists) {
            // Create and display the error message if the code exists
            const message = document.createElement('div');
            message.className = 'alert-message text-danger'; // Customize the class for styling
            message.innerText = `Item Code "${itemCode}" is a pending or an already used item code. Try a different one!`;

            // Remove any existing alert message before displaying the new one
            clearAlertMessage(inputField);

            // Insert the message after the input field
            inputField.parentNode.insertBefore(message, inputField.nextSibling);
          
        } else {
            // Remove the alert message if the item code is unique
            clearAlertMessage(inputField);
        }
    })
    .catch(error => console.error('Error checking item code:', error));
}

// Function to clear the alert message
function clearAlertMessage(inputField) {
    const existingMessage = inputField.nextElementSibling;
    if (existingMessage && existingMessage.classList.contains('alert-message')) {
        existingMessage.remove(); // Remove existing message if present
    }
}
</script>
