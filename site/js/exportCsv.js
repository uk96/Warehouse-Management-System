const exportCsv = (data, fileName) => {
    
    let array = data.map((row) => {
        let singleArray = [];
        Object.keys(row).forEach((key) => {
            singleArray.push(row[key]);
        });
        return singleArray;
    });
    let csvContent = '';
    if(data.length > 0) {
        csvContent += Object.keys(data[0]).join(',') + '\n';
    } 
	array.forEach(function(infoArray, index) {
	    dataString = infoArray.join(',');
	    csvContent += dataString + '\n';
	});

	// Content is the csv generated string above
	let download = (content, fileName, mimeType) => {
        var a = document.createElement('a');
        mimeType = mimeType || 'application/octet-stream';

        if (navigator.msSaveBlob) { // IE10
            navigator.msSaveBlob(new Blob([content], { type: mimeType }), fileName);
        } else if (URL && 'download' in a) { //html5 A[download]
            a.href = URL.createObjectURL(new Blob([content], {
            type: mimeType
            }));
            a.setAttribute('download', fileName);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        } else {
            location.href = 'data:application/octet-stream,' + encodeURIComponent(content); // only this mime type is supported
        }
	}
	download(csvContent, fileName + '.csv', 'text/csv;encoding:utf-8');  
};