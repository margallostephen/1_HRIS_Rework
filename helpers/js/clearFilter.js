function addClearFilter(table) {
    $("#clearAllFilterBtn").off("click").on("click", () => {
        table.getColumns()
            .filter(col => col.getDefinition()?.headerFilter)
            .forEach(col => col.setHeaderFilterValue(""));
    });

    table.on("dataFiltering", filters => {
        const activeFields = filters.map(f => f.field);

        table.getColumns().forEach(col => {
            const field = col.getField();
            const colElement = $(`.tabulator-col[tabulator-field="${field}"]`);
            const filterElement = colElement.find(".tabulator-header-filter");
            const headerContent = $(col.getElement()).find('.tabulator-col-content');
            const clearIcon = colElement.find(".clear-icon");

            if (!clearIcon.length) {
                const icon = $('<i class="fa fa-remove clear-icon" style="cursor:pointer; margin-right:5px;"></i>');
                icon.on("click", e => {
                    e.stopPropagation();
                    table.setHeaderFilterValue(field, "");
                });
                filterElement.before(icon);
            }

            headerContent.toggleClass("tabulator-header-highlight", activeFields.includes(field));
            colElement.find(".clear-icon").toggle(activeFields.includes(field));
        });

        $("#clearAllFilterBtn").text(activeFields.length > 0 ? `Clear (${activeFields.length}) Filter${activeFields.length > 1 ? 's' : ''}` : "Clear Filter").prop("disabled", activeFields.length === 0);
    });
}
