###

<?php
use kartik\grid;
 
// A simple editable content used without a model and the value defaulting to display value. 
// Note that by default the input type is set to `Editable::INPUT_TEXT` and the editable format 
// is displayed as a `Editable::FORMAT_LINK`.
echo '<label>Person Name</label><br>';
echo Editable::widget([
    'name'=>'person_name', 
    'asPopover' => true,
    'value' => 'Kartik Visweswaran',
    'header' => 'Name',
    'size'=>'md',
    'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...']
]);