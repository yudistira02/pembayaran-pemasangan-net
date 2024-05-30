const BASE_URL = 'http://localhost:8080/'
function enlargeImage(imageUrl) {
    var modal = document.createElement('div');
    modal.classList.add('fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'bg-black', 'bg-opacity-75', 'flex', 'justify-center', 'items-center', 'z-50');

    var enlargedImg = document.createElement('img');
    enlargedImg.src = imageUrl;
    enlargedImg.classList.add('max-w-full', 'max-h-full');

    modal.appendChild(enlargedImg);

    document.body.appendChild(modal);

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.remove();
        }
    });
}