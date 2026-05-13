// ajax call to update delivery status without page reload
function updateDeliveryStatus(selectElement) {
    var assignmentId = selectElement.getAttribute('data-id');
    var newStatus = selectElement.value;

    if (!newStatus) return;

    if (!confirm('Update status to "' + newStatus.replace('_', ' ') + '"?')) {
        selectElement.value = '';
        return;
    }

    var row = selectElement.closest('tr');
    var statusBadge = document.getElementById('status-' + assignmentId);

    row.classList.add('status-updating');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/update_delivery_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            row.classList.remove('status-updating');

            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        statusBadge.textContent = response.status_label;
                        row.classList.add('status-updated');

                        if (response.new_status === 'delivered') {
                            setTimeout(function() {
                                row.style.opacity = '0';
                                setTimeout(function() {
                                    row.remove();
                                }, 300);
                            }, 1000);
                        }

                        selectElement.value = '';

                        updateSelectOptions(selectElement, response.new_status);
                    } else {
                        alert('Error: ' + response.message);
                        selectElement.value = '';
                    }
                } catch (e) {
                    alert('Error processing response.');
                    selectElement.value = '';
                }
            } else {
                alert('Server error. Please try again.');
                selectElement.value = '';
            }
        }
    };

    xhr.send('assignment_id=' + encodeURIComponent(assignmentId) + '&status=' + encodeURIComponent(newStatus));
}

function updateSelectOptions(selectElement, currentStatus) {
    selectElement.innerHTML = '<option value="">Change...</option>';

    if (currentStatus === 'picked_up') {
        selectElement.innerHTML += '<option value="in_transit">In Transit</option>';
        selectElement.innerHTML += '<option value="delivered">Delivered</option>';
    } else if (currentStatus === 'in_transit') {
        selectElement.innerHTML += '<option value="delivered">Delivered</option>';
    }
}
