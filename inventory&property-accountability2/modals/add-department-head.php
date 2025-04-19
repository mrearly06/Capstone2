<!-- Add Department Head Modal -->
<div class="modal fade" id="departmentHeadModal" tabindex="-1" aria-labelledby="departmentHeadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="departmentHeadModalLabel">Add Department Head</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body with Form -->
            <div class="modal-body">
                <form id="addDepartmentHeadForm">
                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name or User ID</label>
                        <input type="text" class="form-control" id="nameInput" placeholder="Enter user ID or name">
                        <input type="hidden" id="userIDinput" name="userID"> <!-- Hidden input for user ID -->
                    </div>

                    <!-- Dynamic User Search Results -->
                    <div id="userSearchResults" class="list-group mt-3" style="max-height: 150px; overflow-y: auto;"></div>

                    <!-- Department Input -->
                    <div class="mb-3">
                        <label for="departmentInput" class="form-label">Department</label>
                        <input type="text" class="form-control" id="departmentInput" placeholder="Enter department ID or name">
                        <input type="hidden" id="departmentIDinput" name="departmentID"> <!-- Hidden input for department ID -->
                    </div>

                    <!-- Dynamic Department Search Results -->
                    <div id="departmentSearchResults" class="list-group mt-3" style="max-height: 150px; overflow-y: auto;"></div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="addDepartmentHeadForm">Add Department Head</button>
            </div>
        </div>
    </div>
</div>


<script>
// JavaScript to handle dynamic user search and display list items
document.getElementById('nameInput').addEventListener('input', function() {
    var query = this.value.trim();

    // Only search if the input is not empty
    if (query.length > 0) {
        fetch('backend/fetch-users.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                var userSearchResults = document.getElementById('userSearchResults');
                userSearchResults.innerHTML = ''; // Clear previous results

                // Check if any results are returned
                if (data.length > 0) {
                    data.forEach(user => {
                        // Create a clickable list item for each user
                        var listItem = document.createElement('a');
                        listItem.classList.add('list-group-item', 'list-group-item-action');
                        listItem.href = '#';
                        listItem.innerHTML = `
                            <div onclick="selectUser(${user.userID}, '${user.firstName} ${user.middleName} ${user.lastName}')">
                                <h6>${user.firstName} ${user.middleName} ${user.lastName}</h6>
                                <p class="mb-0">User ID: ${user.userID}</p>
                            </div>
                        `;
                        userSearchResults.appendChild(listItem);
                    });
                } else {
                    // Show no results message
                    userSearchResults.innerHTML = '<p class="text-muted">No matching users found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching users:', error);
            });
    } else {
        // Clear results if input is empty
        document.getElementById('userSearchResults').innerHTML = '';
    }
});

// JavaScript to handle dynamic department search and display list items
document.getElementById('departmentInput').addEventListener('input', function() {
    var query = this.value.trim();

    // Only search if the input is not empty
    if (query.length > 0) {
        fetch('backend/fetch-departments.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                var departmentSearchResults = document.getElementById('departmentSearchResults');
                departmentSearchResults.innerHTML = ''; // Clear previous results

                // Check if any results are returned
                if (data.length > 0) {
                    data.forEach(department => {
                        // Create a clickable list item for each department
                        var listItem = document.createElement('a');
                        listItem.classList.add('list-group-item', 'list-group-item-action');
                        listItem.href = '#';
                        listItem.innerHTML = `
                            <div onclick="selectDepartment(${department.departmentID}, '${department.departmentName}')">
                                <h6>${department.departmentName}</h6>
                                <p class="mb-0">Department ID: ${department.departmentID}</p>
                            </div>
                        `;
                        departmentSearchResults.appendChild(listItem);
                    });
                } else {
                    // Show no results message
                    departmentSearchResults.innerHTML = '<p class="text-muted">No matching departments found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching departments:', error);
            });
    } else {
        // Clear results if input is empty
        document.getElementById('departmentSearchResults').innerHTML = '';
    }
});

// Function to handle when a user is selected from the search results
function selectUser(userID, userName) {
    // Set the selected user's details in the form
    document.getElementById('nameInput').value = userName;
    document.getElementById('userIDinput').value = userID;

    // Clear the user search results
    document.getElementById('userSearchResults').innerHTML = '';
}

// Function to handle when a department is selected from the search results
function selectDepartment(departmentID, departmentName) {
    // Set the selected department's details in the form
    document.getElementById('departmentInput').value = departmentName;
    document.getElementById('departmentIDinput').value = departmentID;

    // Clear the department search results
    document.getElementById('departmentSearchResults').innerHTML = '';
}
</script>

<script>
document.getElementById('addDepartmentHeadForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get userID and departmentID
    const userID = document.getElementById('userIDinput').value; // Assuming this is set to userID
    const departmentID = document.getElementById('departmentIDinput').value; // Get department ID from input

    // Prepare data to be sent in the POST request
    const formData = new FormData();
    formData.append('userID', userID);
    formData.append('departmentID', departmentID);

    // Log the form data to the console
    console.log('Form Data:', {
        userID: userID,
        departmentID: departmentID
    });

    // Send data to the server
    fetch('backend/add-department-head-query.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Change to .text() to see the raw response
    .then(data => {
        console.log(data); // Log the response to check for HTML or error messages
        try {
            const jsonData = JSON.parse(data); // Try to parse as JSON
            if (jsonData.success) {
                alert(jsonData.message); // Display success message
                
                // Reset the form fields
                document.getElementById('addDepartmentHeadForm').reset();
                // Clear hidden inputs to prevent unwanted submissions
                document.getElementById('userIDinput').value = '';
                document.getElementById('departmentIDinput').value = '';
                
                // Hide modal after resetting the form
                $('#departmentHeadModal').modal('hide');
            } else {
                alert(jsonData.message); // Display error message if not successful
            }
        } catch (e) {
            console.error('Error parsing JSON:', e);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

    </script>