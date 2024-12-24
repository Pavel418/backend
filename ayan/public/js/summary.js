$(document).ready(function () {
    $(document).on('click', '.edit-btn', function() {
        var row = $(this).closest('tr');
        var experienceId = row.data('id');
    
        window.location.href = '/experience/edit?' + experienceId;
    });
    

    $(document).on('click', '.delete-btn', function() {
        var row = $(this).closest('tr');
        var experienceId = row.data('id');
        
        $.ajax({
            url: '/api/experience/delete',
            method: 'POST',
            data: { id: experienceId },
            success: function(response) {
                row.remove();
                console.log('Experience deleted successfully:', response);
                alert('Experience deleted successfully');
            },
            error: function(err) {
                console.error('Error deleting experience:', err);
                alert('Error deleting experience');
            }
        });
    });
    
});
