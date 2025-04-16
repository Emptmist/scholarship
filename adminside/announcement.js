document.getElementById('announcementForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const title = document.getElementById('title').value;
    const body = document.getElementById('body').value;
    const zwhen = document.getElementById('zwhen').value;
    const zwhere = document.getElementById('zwhere').value;
    const posted_to = document.getElementById('posted_to').value;
    const ann_pic = document.getElementById('pic_ann').files[0];

    const formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);
    formData.append('zwhen', zwhen);
    formData.append('zwhere', zwhere);
    formData.append('posted_to', posted_to);
    if (ann_pic) {
        formData.append('pic_ann', ann_pic);
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to post this announcement?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, post it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms, send the data using fetch
            fetch('post_announcement.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    Swal.fire(
                        'Posted!',
                        'Your announcement has been posted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                    // Optionally, reset the form here
                    document.getElementById('announcementForm').reset();
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'There was an error posting your announcement.',
                        'error'
                    );
                });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                'Your announcement was not posted.',
                'error'
            );
        }
    });
});


function updateCharCount() {
    const textarea = document.getElementById('title');
    const charCountDisplay = document.getElementById('charCount');
    const currentLength = textarea.value.length;
    const maxLength = textarea.maxLength;
    charCountDisplay.textContent = `${currentLength} / ${maxLength} characters`;
}
