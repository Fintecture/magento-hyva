(function () {
    const targetId = 'payment-method-fintecture-description';

    const checkAndRemovePadding = () => {
        const method = document.getElementById(targetId);
        if (method && method.dataset.design === 'ist_short') {
            const wrapper = method.closest('#payment-method-view-fintecture');
            if (wrapper) {
                wrapper.classList.remove('p-4');
            }
            return true;
        }
        return false;
    };

    const startObserver = () => {
        const body = document.body;
        if (!body) {
            return setTimeout(startObserver, 50); // retry in 50ms
        }

        const observer = new MutationObserver(() => {
            if (checkAndRemovePadding()) {
                observer.disconnect();
            }
        });

        observer.observe(body, {
            childList: true,
            subtree: true,
        });
    };

    if (checkAndRemovePadding()) {
        return;
    }

    startObserver();
})();