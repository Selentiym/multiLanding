<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2017
 * Time: 17:39
 */

Yii::app() -> getClientScript() -> registerCoreScript('bootstrap-editable');

$url = $this -> createUrl('admin/editOurClinic');
?>
<div class="docdoc-clinics">
    <table border="1">
        <thead>
        <tr>
            <th style="padding:10px;">docdoc_id</th>
            <th style="padding:10px;">Название docdoc</th>
            <th style="padding:10px;">Адрес docdoc</th>
            <th style="padding:10px;">Наше id</th>
            <th style="padding:10px;">Наше название</th>
            <th style="padding:10px;">Наше Адрес</th>
            <th style="padding:10px;">Наше docdoc_id</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $clinic) {
            echo '<tr style="background-color:#ffd8d6">'
                . '<td style="padding:10px;">' . $clinic['Id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['Name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['City'] . ' ' . $clinic['Street'] . ' ' . $clinic['House'] . '</td>'
                . '<td ></td><td ></td><td ></td><td ></td>'
                . '</tr>';
        }

        foreach ($ourClinicsAndDocdoc as $clinic) {
            echo '<tr style="background-color:#c2f9c8">'
                . '<td style="padding:10px;">' . $clinic['docdoc_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_adress'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_address'] . '</td>'
                . '<td style="padding:10px;"><span '
                . 'class="no-error fieldEditable" '
                . 'data-pk="'. $clinic['our_id'] .'" '
                . 'data-type="number" '
                . 'data-name="docdoc_id" '
                . 'data-url="'. $url .'">'
                . $clinic['our_docdoc_id'] . '</span></td>'
                . '</tr>';
        }

        foreach ($ourClinicsNotDocdoc as $clinic) {
            echo '<tr style="background-color:#c2daf9">'
                . '<td style="padding:10px;">' . $clinic['docdoc_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_adress'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_address'] . '</td>'
                . '<td style="padding:10px;"><span '
                . 'class="no-error fieldEditable" '
                . 'data-pk="'. $clinic['our_id'] .'" '
                . 'data-type="number" '
                . 'data-name="docdoc_id" '
                . 'data-url="'. $url .'">'
                . $clinic['our_docdoc_id'] . '</span></td>'
                . '</tr>';
        }

        foreach ($ourClinicsAbsentDocdoc as $clinic) {
            echo '<tr style="background-color:red">'
                . '<td style="padding:10px;">' . $clinic['docdoc_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['docdoc_adress'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_id'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_name'] . '</td>'
                . '<td style="padding:10px;">' . $clinic['our_address'] . '</td>'
                . '<td style="padding:10px;"><span '
                . 'class="no-error fieldEditable" '
                . 'data-pk="'. $clinic['our_id'] .'" '
                . 'data-type="number" '
                . 'data-name="docdoc_id" '
                . 'data-url="'. $url .'">'
                . $clinic['our_docdoc_id'] . '</span>'
                . '</td>'
                . '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.fieldEditable').editable({
            mode: 'inline',
            params: {
                type: $(this).attr('data-type')
            }
        });
    });
</script>

