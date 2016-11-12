<?php
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$wbdata = $_SESSION['wbData'];
// echo '<script>window.console.log('.print_r($wbdata).');</script>';

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IBOU');
$pdf->SetTitle('Report for Brainstorming');
$pdf->SetSubject('ベビーウェアラブル機器');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//     require_once(dirname(__FILE__).'/lang/eng.php');
//     $pdf->setLanguageArray($l);
// }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

$pdf->SetFont('ipaexg');

// add a page
$pdf->AddPage();

// create some HTML content
// $subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = <<<EOF
<style>
table {
    border-collapse:collapse;
    width: 100%;
}
table, th, td {
    border:1px solid black;
}
</style>
<table>
    <tr>
        <th align="center" colspan="4"><br/><br/><h4>第一次会議報告書</h4><br/><br/></th>
    </tr>
    <tr>
        <td colspan="2" width="20%"><br/><br/>区分<br/></td>
        <td colspan="2" width="80%"><br/><br/>内容<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>日時<br/></td>
        <td colspan="2"><br/><br/>2016年 09月 26日 16 時 00 分 ~ 17 時 00 分<br/></td>
    </tr>
    <tr>
        <td rowspan="2"><br/><br/>チーム構成<br/></td>
        <td><br/><br/>進行者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン<br/></td>
    </tr>
    <tr>
        <td><br/><br/>参加者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン、パク・セジン、シン・ミョンギル、キム・クァンヨン<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>テーマ<br/></td>
        <td colspan="2"><br/><br/>ベビーウェアラブル機器企画<br/></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="5"><br/><br/>ベビー<br/><br/>ウェアラブル<br/><br/>機器<br/><br/></td>
        <td width="65%"><br/><br/>アイデアリスト<br/></td>
        <td width="15%"><br/><br/>採択結果<br/></td>
    </tr>
    <tr>
        <td><br/><br/>価格<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>機能<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>部位<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>重さ<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = <<<EOF
<style>
table {
    border-collapse:collapse;
    width: 100%;
}
table, th, td {
    border:1px solid black;
}
</style>
<table>
    <tr>
        <th align="center" colspan="4"><br/><br/><h4>第二次会議報告書</h4><br/><br/></th>
    </tr>
    <tr>
        <td colspan="2" width="20%"><br/><br/>区分<br/></td>
        <td colspan="2" width="80%"><br/><br/>内容<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>日時<br/></td>
        <td colspan="2"><br/><br/>2016年 09月 29日 16 時 00 分 ~ 17 時 00 分<br/></td>
    </tr>
    <tr>
        <td rowspan="2"><br/><br/>チーム構成<br/></td>
        <td><br/><br/>進行者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン<br/></td>
    </tr>
    <tr>
        <td><br/><br/>参加者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン、パク・セジン、シン・ミョンギル、キム・クァンヨン<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>テーマ<br/></td>
        <td colspan="2"><br/><br/>ベビーウェアラブル機器企画<br/></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="4"><br/><br/>価格<br/></td>
        <td width="65%"><br/><br/>アイデアリスト<br/></td>
        <td width="15%"><br/><br/>採択結果<br/></td>
    </tr>
    <tr>
        <td><br/><br/>5000円<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>10000円<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>15000円<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = <<<EOF
<style>
table {
    border-collapse:collapse;
    width: 100%;
}
table, th, td {
    border:1px solid black;
}
</style>
<table>
    <tr>
        <th align="center" colspan="4"><br/><br/><h4>第三次会議報告書</h4><br/><br/></th>
    </tr>
    <tr>
        <td colspan="2" width="20%"><br/><br/>区分<br/></td>
        <td colspan="2" width="80%"><br/><br/>内容<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>日時<br/></td>
        <td colspan="2"><br/><br/>2016年 10月 3日 16 時 00 分 ~ 17 時 00 分<br/></td>
    </tr>
    <tr>
        <td rowspan="2"><br/><br/>チーム構成<br/></td>
        <td><br/><br/>進行者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン<br/></td>
    </tr>
    <tr>
        <td><br/><br/>参加者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン、パク・セジン、シン・ミョンギル、キム・クァンヨン<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>テーマ<br/></td>
        <td colspan="2"><br/><br/>ベビーウェアラブル機器企画<br/></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="4"><br/><br/>機能<br/></td>
        <td width="65%"><br/><br/>アイデアリスト<br/></td>
        <td width="15%"><br/><br/>採択結果<br/></td>
    </tr>
    <tr>
        <td><br/><br/>体温チェック機能<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>排便アラーム機能<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>睡眠状態のお知らせ機能<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = <<<EOF
<style>
table {
    border-collapse:collapse;
    width: 100%;
}
table, th, td {
    border:1px solid black;
}
</style>
<table>
    <tr>
        <th align="center" colspan="4"><br/><br/><h4>第四次会議報告書</h4><br/><br/></th>
    </tr>
    <tr>
        <td colspan="2" width="20%"><br/><br/>区分<br/></td>
        <td colspan="2" width="80%"><br/><br/>内容<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>日時<br/></td>
        <td colspan="2"><br/><br/>2016年 10月 6日 16 時 00 分 ~ 17 時 00 分<br/></td>
    </tr>
    <tr>
        <td rowspan="2"><br/><br/>チーム構成<br/></td>
        <td><br/><br/>進行者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン<br/></td>
    </tr>
    <tr>
        <td><br/><br/>参加者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン、パク・セジン、シン・ミョンギル、キム・クァンヨン<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>テーマ<br/></td>
        <td colspan="2"><br/><br/>ベビーウェアラブル機器企画<br/></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="4"><br/><br/>部位<br/></td>
        <td width="65%"><br/><br/>アイデアリスト<br/></td>
        <td width="15%"><br/><br/>採択結果<br/></td>
    </tr>
    <tr>
        <td><br/><br/>手首<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>足首<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>首<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = <<<EOF
<style>
table {
    border-collapse:collapse;
    width: 100%;
}
table, th, td {
    border:1px solid black;
}
</style>
<table>
    <tr>
        <th align="center" colspan="4"><br/><br/><h4>第五次会議報告書</h4><br/><br/></th>
    </tr>
    <tr>
        <td colspan="2" width="20%"><br/><br/>区分<br/></td>
        <td colspan="2" width="80%"><br/><br/>内容<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>日時<br/></td>
        <td colspan="2"><br/><br/>2016年 10月 9日 16 時 00 分 ~ 17 時 00 分<br/></td>
    </tr>
    <tr>
        <td rowspan="2"><br/><br/>チーム構成<br/></td>
        <td><br/><br/>進行者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン<br/></td>
    </tr>
    <tr>
        <td><br/><br/>参加者<br/></td>
        <td colspan="2"><br/><br/>リー・ジュンソン、パク・セジン、シン・ミョンギル、キム・クァンヨン<br/></td>
    </tr>
    <tr>
        <td colspan="2"><br/><br/>テーマ<br/></td>
        <td colspan="2"><br/><br/>ベビーウェアラブル機器企画<br/></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="4"><br/><br/>重さ<br/></td>
        <td width="65%"><br/><br/>アイデアリスト<br/></td>
        <td width="15%"><br/><br/>採択結果<br/></td>
    </tr>
    <tr>
        <td><br/><br/>100g<br/></td>
        <td><br/><br/>採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>150g<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
    <tr>
        <td><br/><br/>200g<br/></td>
        <td><br/><br/>未採択<br/></td>
    </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Print some HTML Cells

// $html = '<span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span><br /><span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span>';

// $pdf->SetFillColor(255,255,0);

// $pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
// $pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 1, true, 'C', true);
// $pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'R', true);

// reset pointer to the last page
$pdf->lastPage();


//Close and output PDF document
$pdf->Output('Report_for_ベビーウェアラブル機器_Brainstorming.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+