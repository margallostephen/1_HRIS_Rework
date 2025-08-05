function createTable(name, rowId, columns, data, layout = "fitColumns") {
    const withActions = [
        {
            field: rowId,
            headerFilter: "input",
            vertAlign: "middle",
            visible: false,
        },
        ...columns,
        {
            title: "ACTIONS",
            field: rowId,
            hozAlign: "center",
            headerSort: false,
            frozen: window.innerWidth > 728,
            cssClass: "action-column",
            formatter: function (cell) {
                const id = Object.values(cell.getData())[0];

                return `
                    <button class="btn btn-md btn-warning editModalBtn" data-id="${id}">Edit</button>
                    <button class="btn btn-md btn-danger deleteBtn" data-id="${id}">Delete</button>`;
            },
        },
    ];

    const table = new Tabulator(`#${name}-table`, {
        height: "636px",
        layout: layout,
        autoResize: true,
        pagination: "local",
        paginationSize: 10,
        paginationCounter: "rows",
        paginationSizeSelector: [10, 25, 50, 100, true],
        placeholder: "No records available",
        columns: withActions,
        data: data,
        rowFormatter: function (row) {
            const { ACTIVE } = row.getData();
            const $el = $(row.getElement());

            if (ACTIVE === 'INACTIVE') {
                $el.css({
                    color: '#FF1D1D',
                    backgroundColor: '#F9EBEA'
                });
            }
        },
    });

    return table;
}