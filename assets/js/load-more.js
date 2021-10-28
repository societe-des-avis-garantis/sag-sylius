const loadMoreElement = document.querySelector('[data-sag-load-more]');

if (loadMoreElement) {
    const reviewCount = parseInt(loadMoreElement.dataset.sagReviewCount);
    const maxPerPage = parseInt(loadMoreElement.dataset.sagMaxPerPage);
    const lastPage = Math.ceil(reviewCount / maxPerPage);

    const reviewListContainer = document.querySelector(loadMoreElement.dataset.sagReviewListContainerSelector);

    loadMoreElement.addEventListener('click', (e) => {
        e.preventDefault();

        const nextPage = parseInt(loadMoreElement.dataset.sagPage) + 1;
        if (nextPage > lastPage) {
            return;
        }

        loadMoreElement.dataset.sagPage = nextPage;

        const url = loadMoreElement.dataset.sagUrl.replace('CURRENT_PAGE', nextPage);

        loadMoreElement.classList.add('loading');
        loadMoreElement.disabled = true;

        fetch(url).then((response) => {
            if (!response.ok) {
                loadMoreElement.classList.remove('loading');
                loadMoreElement.disabled = false;

                throw new Error('Network response was not ok');
            }

            return response.text();
        }).then(text => {
            reviewListContainer.innerHTML += text;

            if (lastPage <= nextPage) {
                loadMoreElement.style.display = 'none';
            }

            loadMoreElement.classList.remove('loading');
            loadMoreElement.disabled = false;
        });
    });
}
