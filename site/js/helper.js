const makeTable = (columnNames, data, isEdit) => {
    let tableData = '<thead><tr>';
    columnNames.forEach(columnName => {
        tableData += ('<th>' + columnName.value + '</th>');
    });
    if(isEdit){
        tableData += ('<th>Option</th>');
    }
    tableData += '</tr></thead>';
    data.forEach(row => {
        tableData += '<tr>';
        columnNames.forEach(columnName => {
            tableData += ('<td>' + row[columnName.key] + '</td>');
        }); 
        if(isEdit){
            tableData += (`<td>
                <div class="table-button">
                    <div id="edit-product" class="edit-product minimize-search button" data-id=${row['productId']}>
                        <i class="fa fa-edit small-font-icon" aria-hidden="true"></i>
                    </div>
                    <div id="delete-product" class="delete-product minimize-search button small-margin-left" data-id="${row['productId']}">
                        <i class="fa fa-trash-alt small-font-icon" aria-hidden="true"></i>
                    </div>
                </div>
            </td>`);
        }
        tableData += '</tr>';
    });
    return tableData
};