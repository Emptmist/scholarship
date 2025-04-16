document.addEventListener('DOMContentLoaded', () => {
    fetch('retrieve-announcements.php')
        .then(response => response.json())
        .then(data => {
            const dataWrapper = document.getElementById('data-wrapper');
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'data-container';

                const title = document.createElement('div');
                title.className = 'data-title';
                title.textContent = item.title;

                const postDate = new Date(item.post_date).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
                const postDateDiv = document.createElement('div');
                postDateDiv.className = 'data-post-date';
                postDateDiv.textContent = postDate;

                if (item.ann_pic) {
                    const img = document.createElement('img');
                    img.src = './admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic;
                    img.alt = 'Announcement Image';
                }

                const content = document.createElement('div');
                content.className = 'data-content';
                content.textContent = item.body;


                const seeMoreButton = document.createElement('button');
                seeMoreButton.className = 'see-more';
                seeMoreButton.textContent = 'See More';
                seeMoreButton.addEventListener('click', () => {
                    Swal.fire({
                        title: item.title,
                        html: `
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                <p style="margin: 0 0 20px 0; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 2%;">
                                    <span><strong>When:</strong> ${item.zwhen || 'N/A'}</span>
                                    <span><strong>Where:</strong> ${item.zwhere || 'N/A'}</span>
                                </p>
                                ${item.ann_pic ? '<img src="../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic + '" style="width: 700px; height: 300px; object-fit: cover; position:relative; border-style: solid; border-radius:4px;margin-top:3%;margin-bottom:3%;">' : ''}
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    ${item.body}
                                </p>
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    <strong>Posted on:</strong> ${postDate}
                                </p>
                            </div>
                        `,
                        width: '80%',
                        padding: '3em',
                        background: '#fff',
                        confirmButtonText: 'Close'
                    });
                });

                div.appendChild(title);
                div.appendChild(postDateDiv);
                div.appendChild(seeMoreButton);
                dataWrapper.appendChild(div);

                // Debugging statements
                console.log('Scroll Height:', content.scrollHeight);
                console.log('Client Height:', content.clientHeight);

                // Force button visibility for debugging
                seeMoreButton.style.display = 'inline-block';

                // Check if content exceeds the allowed height
                if (content.scrollHeight > content.clientHeight) {
                    seeMoreButton.style.display = 'inline-block';
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
