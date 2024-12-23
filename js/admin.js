
document.addEventListener('DOMContentLoaded', function(){
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#dataTable tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (nameCell.includes(searchTerm)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });
});