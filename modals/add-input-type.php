<!-- Modal for Additional Input -->
<div class="modal fade" id="additionalInputModal" tabindex="-1" aria-labelledby="additionalInputModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="additionalInputModalLabel">Additional Input</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="additionalInputForm">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-8 d-flex gap-2">
                            <label for="additionalInput" class="form-label" style="white-space: nowrap;">Add input text</label> <!-- Prevent wrapping -->
                            <input type="number" class="form-control" id="additionalInput" name="additionalInput" placeholder="" min="0">
                            <button type="button" class="btn bg-primary-subtle" onclick="addInputField()">
                                <i class="fas fa-plus"></i> <!-- Plus icon using Font Awesome -->
                            </button>
                        </div>
                    </div>
                    <div id="additionalInputsContainer"></div> <!-- Container for additional input fields -->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#addItemModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back to first</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitAdditionalInput()">Submit</button>
            </div>
        </div>
    </div>
</div>

