document.addEventListener('DOMContentLoaded', initCTAVideos);

function initCTAVideos() {
    const videoElems = document.querySelectorAll('button.video-trigger');
    videoElems.forEach((playButton) => {
        let targetVideoID = playButton.getAttribute('aria-controls');
        let videoElem = document.getElementById(targetVideoID);
        if (videoElem !== null) {
            let videoID = playButton.dataset.vid;
            let videoHolderElem = document.getElementById('videoholder-' + videoID);
            let modalCloser = videoHolderElem.querySelector(':scope button.modal-closer');
            playButton.addEventListener('click', () => {
                videoHolderElem.showModal();
                videoElem.play();
            });
            modalCloser.addEventListener('click', () => {
               videoHolderElem.close();
               videoElem.pause();
            });
        }
    });
}
