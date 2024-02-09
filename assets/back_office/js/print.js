function print(div){
        var divContents = $(div).html();
        var printWindow = window.open('', '', 'height=720,width=1280');
        printWindow.document.write('<html><head><title>Export PDF</title>');
        printWindow.document.write('<link rel="stylesheet" type="text/css" href="http://localhost/gescom/assets/back_office/css/demo1/style.css">');
        printWindow.document.write('<link rel="stylesheet" type="text/css"href="http://localhost/gescom/assets/back_office/vendors/flag-icon-css/css/flag-icon.min.css">');
        printWindow.document.write('<link rel="stylesheet"  type="text/css" href="http://localhost/gescom/assets/back_office/fonts/feather-font/css/iconfont.css">');
        printWindow.document.write('<link rel="stylesheet" type="text/css" href="http://localhost/gescom/assets/back_office/vendors/core/core.css">');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
}
