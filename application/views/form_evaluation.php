<?php

defined('BASEPATH') or exit('direct script not allowed.');
echo $msg;
echo '<center>';
echo form_open(base_url('evaluate/index/' . $faculty_id . '/' . $schedule_id), array(
    'name' => 'basic_validate',
));

$data = array();
 $data['--'] = '--';
for ($i = 0; $i <= 9; $i++) {
    $data[$i] = $i;
}
echo validation_errors('<span style="color:red">', '</span><br />');

echo '<table id="rounded-corner" cellpadding="10" cellspacing="0" border="0" align="center" style="width: 100%">';
echo '<tr>'
 . '<th scope="col" class="rounded-company" align="center">No.</th>'
 . '<th scope="col" class="rounded-company" align="center">Key</th>'
 . '<th scope="col" class="rounded-company" align="center">Question</th>'
 . '<th scope="col" class="rounded-company" align="center">Score</th>'
 . '</tr>';
foreach ($my_input['inputs'] as $kk => $vv):
    echo '<tr>';

    echo '<th  scope="col" class="rounded-company" align="center" colspan="4">' . form_label($vv['cat'], $kk) . '</th></tr>';


    foreach ($vv['ques'] as $k => $v):
        echo '<tr>';
        echo '<td align=center>';
        echo $k;
        echo '</td>';
        echo '<td>';
        echo $v['label'];
        echo '</td>';
        echo '<td>' . form_label($v['question'], $v['field']) . '</td>';

        echo '<td>' . form_dropdown($v['field'], $data, set_value($v['field'])) . '</td>';

        echo '</tr>';
    endforeach;
endforeach;

echo '<tr>';
echo '<td>' . form_label($my_input['label_textarea'], $my_input['field_textarea']) . '</td>';

$data = array(
    'name' => $my_input['field_textarea'],
    'value' => set_value($my_input['field_textarea']),
    'rows' => '3',
    'cols' => '10',
    'style' => 'width:100%',
    'placeholder' => $my_input['label_textarea'],
);
echo '<td colspan="3">';
echo form_textarea($data);
echo '</td>';


echo '</tr>';
echo '</table>';
echo form_submit($my_input['button_name'], $my_input['button_label'], array(
    'class' => 'btn btn-success'
));

echo form_reset('reset', 'Reset', array(
    'class' => 'btn btn-success'
));

echo form_close();
echo '</center>';
