function handleResponsiveColumnFreeze(table, fields, rowId) {
    const responsiveFields = [...new Set([...fields, rowId])];
    let lastState = null;

    const debounce = (fn, delay = 100) => {
        let timeout;
        return () => {
            clearTimeout(timeout);
            timeout = setTimeout(fn, delay);
        };
    };

    const update = () => {
        const freeze = window.innerWidth > 728;

        if (freeze === lastState) return;
        lastState = freeze;

        for (const field of responsiveFields) {
            table.updateColumnDefinition(field, { frozen: freeze });
        }

        table.redraw(true);
    };

    window.addEventListener("resize", debounce(update));
}
