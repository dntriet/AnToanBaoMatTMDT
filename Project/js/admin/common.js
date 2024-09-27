const table = document.querySelector('.admin-table table');
const page_name = $('.section_heading').text();


//START: CONFIRMATION POPUP----------
// exit confirmation popup
document.addEventListener('DOMContentLoaded', function() {
const cancelButton = document.querySelector('.btn-cancel');

cancelButton.addEventListener('click', function() {
    if (confirm('Những thay đổi của bạn sẽ không được lưu?')) {
    // Dismiss the modal if the user clicks "OK" in the confirm box
    // Replace 'myModal' with the actual ID of your Bootstrap modal
    $('#add-new').modal('hide');

    // Clear the data and reset the form validation in the modal
      const modal = document.getElementById('add-new');
      modal.querySelector('form').reset(); // Reset the form

    Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
    element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
    });

    } else {
    // Do not dismiss the modal if the user clicks "Cancel" in the confirm box
    }
});
});

//END: CONFIRMATION POPUP----------


//START: EXPORT TABLE TO EXCEL---------
// Converting HTML table to EXCEL File
const export_btn = document.querySelector('.btn-export');

const toExcel = function (table, includeImages) {
    const t_heads = table.querySelectorAll('th');
    const tbody_rows = table.querySelectorAll('tr');

    const headings = [...t_heads].slice(0, -1).map(head => {
        let actual_head = head.textContent.trim().split(' ');
        return actual_head.join(' ');
    });

    const table_data = [...tbody_rows].map(row => {
        const cells = row.querySelectorAll('td');
        const data_without_img = [...cells].slice(0, -1).map(cell => cell.textContent.trim());
        return data_without_img;
    });

    if (includeImages) {
        // TODO:Include logic to handle exporting images if needed
    }

    const data = [headings, ...table_data];
    return data;
}

export_btn.addEventListener('click', () => {
    const data = toExcel(table, true);
    const worksheet = XLSX.utils.aoa_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
    var file_name = page_name + '.xlsx';
    XLSX.writeFile(workbook, file_name);
});

//END: EXPORT TABLE TO EXCEL---------