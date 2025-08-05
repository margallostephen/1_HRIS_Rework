function waitForOptionsChange(selector, callback) {
    const $target = $(selector);
    const observer = new MutationObserver(() => {
        if ($target.find("option").length > 1) {
            observer.disconnect();
            callback();
        }
    });
    observer.observe($target[0], { childList: true });
}