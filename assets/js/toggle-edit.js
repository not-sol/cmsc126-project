function toggleEdit() {
    document.querySelectorAll('.edit-column').forEach(col => {
        col.classList.toggle('d-none');
    });
}