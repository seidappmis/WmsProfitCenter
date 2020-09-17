<style type="text/css">
    @font-face {
    font-family: CCode39;
    src: url(/fonts/ConnectCode39.ttf);
}
body {
    background-color: #fff;
}
.title {
    font-size: 12pt;
    font-weight: 700;
}
.barcode {
    font-family: CCode39;
    font-size: 11pt;
}
.main-table-border td {
    border: 1px solid black;
}
footer {
    font-size: 9px;
    color: #f00;
    text-align: center;
}
@page {
    size: A4;
    margin: 11mm 17mm 17mm 17mm;
}
@media print {
    footer {
        position: fixed;
        bottom: 0;
    }
    .content-block, p {
        page-break-inside: avoid;
    }
    html, body {
        width: 210mm;
        height: 297mm;
    }
}
</style>