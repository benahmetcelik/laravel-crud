<?php

namespace Crud\Classes;

class FormGenerate
{

    public static function generate($formInputs, $model)
    {

        $form = '';
        foreach ($formInputs as  $key=>$value) {


            $form .= self::generateInput($key = 0, $value, $model);
        }
        return $form;
    }

    public static function generateForm($model_details)
    {

        $form_details = $model_details['form'];


        $form = '';

        $form .= '      <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">' . $form_details['title'] . '</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="' . $form_details['action'] . '" method="POST" name="' . $form_details['formName'] . '" ' . (array_key_exists('formEnctype', $form_details) ? 'enctype="' . $form_details['formEnctype'] . '"' : '') . ' id="' . $form_details['formId'] . '"  class="' . $form_details['formClass'] . '">
                            <div class="card-body">
                                ' . self::generate($model_details['formInputs'], $model_details['model']) . '
                            </div>
                            <input name="_token" value="' . csrf_token() . '" hidden>
                            ' . method_field($form_details['method']) . '
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="' . $form_details['formSubmitClass'] . '"><i class="' . $form_details['formSubmitIcon'] . '"></i> ' . $form_details['submit'] . '</button>
                                <a href="' . $form_details['formCancelRoute'] . '" class="' . $form_details['formCancelClass'] . '"><i class="' . $form_details['formCancelIcon'] . '"></i> ' . $form_details['formCancelText'] . '</a>
                            </div>
                            </form>
                            </div>
                            ';


        return $form;
    }

    public static function generateInput($key, $value, $model)
    {




        $input = '';
        switch ($value['type']) {
            case 'text':
                $input = self::generateText($key, $value, $model);
                break;
            case 'color':
                $input = self::generateColor($key, $value, $model);
                break;
            case 'select':
                $input = self::generateSelect($key, $value, $model);
                break;
            case 'file':
                $input = self::generateFile($key, $value, $model);
                break;
            case 'textarea':
                $input = self::generateTextarea($key, $value, $model);
                break;
            default:
                $input = self::generateText($key, $value, $model);
                break;
        }
        return $input;
    }

    public static function generateColor($key, $value, $model){

        if (!array_key_exists('required', $value)) {
            $value['required'] = false;
        }
        if (!array_key_exists('placeholder', $value)) {
            $value['placeholder'] = translate('backend','Enter '.$value['name']);
        }
        $value['label'] = translate('backend',$value['name']);

        $key = $value['name'];

        $input = '<div class="form-group">
                    <label for="' . $key . '">' . $value['label'] . '</label>
                    <input  required="' . $value['required'] . '" type="color" class="form-control" id="' . $key . '" name="' . $key . '" placeholder="' . $value['placeholder'] . '" value="' . old($key, isset($model) ? $model->$key : null) . '">
                </div>';
        return $input;
    }

    public static function generateText($key, $value, $model)
    {



        if (array_key_exists('required', $value)) {
            $value['required'] = 'required="required"';
        }else{
            $value['required'] = '';
        }
        if (!array_key_exists('placeholder', $value)) {
            $value['placeholder'] = translate('backend','Enter '.$value['name']);
        }

      $value['label'] = translate('backend',$value['label']);
       // $key = $value['name'];



        $input = '<div class="form-group">
                    <label for="' . $key.rand(0,99999) . '">' . $value['label'] . '</label>
                    <input  ' . $value['required'] . ' type="text" class="form-control" id="' . $key.rand(0,99999) . '" name="' .  $value['name'] . '" '.($value['name'] == 'slug' ? ' ' : '').' placeholder="' . $value['placeholder'] . '" value="' . old($key, isset($model) ? $model->{$value['name']} : null) . '">
                </div>';
        return $input;
    }

    public static function generateSelect($key, $value, $model)
    {

        if (!array_key_exists('required', $value)) {
            $value['required'] = false;
        }
        if (!array_key_exists('placeholder', $value)) {
            $value['placeholder'] = translate('backend','Enter '.$value['name']);
        }
        $value['label'] = translate('backend',$value['label']);

        $key = $value['name'];
        $input = '<div class="form-group">
                    <label for="' . $key . '">' . $value['label'] . '</label>
                    <select class="form-control" id="' . $key . '" name="' . $value['name'] . '" required="' . $value['required'] . '">
                        <option value="">' . $value['placeholder'] . '</option>';

        if (array_key_exists('options',$value)){
            foreach ($value['options'] as $optionKey => $optionValue) {
                $input .= '<option value="' . $optionKey . '" ' . (old($key, isset($model) ? $model->$key : null) == $optionKey ? 'selected' : null) . ' >' . $optionValue . '</option>';
            }
        }

        if (array_key_exists('relation', $value)) {
            $relation = $value['relation']['model']::get();

            foreach ($relation as $relationKey => $relationValue) {

                $input .= '<option value="' . $relationValue->id . '" ' . (old($key, isset($model) ? $model->$key : null) == $relationValue->id ? 'selected' : null) . ' >' . $relationValue->{$value['relation']['value']} . '</option>';


            }

        }
        $input .= '</select>
                </div>';


        return $input;
    }

    public static function generateFile($key, $value, $model)
    {


        if (!array_key_exists('required', $value)) {
            $value['required'] = false;
        }
        if (!array_key_exists('placeholder', $value)) {
            $value['placeholder'] = translate('backend','Enter '.$value['name']);
        }
        $value['label'] = translate('backend',$value['label']);

        $key = $value['name'];


        $required = (isset($model)) ? '' :( $value['required'] == 'required' ? 'required="required"' : '');

        if (!array_key_exists('multiple', $value)) {
            $value['multiple'] = true;
        }

        $input = '<div class="form-group">
                    <label for="' . $key . '">' . $value['label'] . '</label>
                    <input  ' .$required . ' type="file" class="form-control" id="' . $key . '" name="' . $key . '" placeholder="' . $value['placeholder'] . '"  multiple="' . $value['multiple'] . '"  ">
                    ';



        $name = str_replace('[]', '', $key);


        if (isset($model) && $model->{$name} != null) {
            if (json_decode($model->{$name})) {
                foreach (json_decode($model->{$name}) as $file) {
                    $randID = rand(1, 100000);
                    $input .= '<div id="'.$randID.'" class="mt-3"> <a href="' . asset( $file) . '" target="_blank" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> ' . basename($file) . '</a> <badge class="btn btn-danger" onclick="document.getElementById(\''.$randID.'\').remove();"><i class="fa fa-times"></i></badge>
<input type="text" name="'.$name.'[]" value="'.$file.'" hidden>
</div>';
                }

            } else {
                $randID = rand(1, 100000);
                $input .= '<div id="'.$randID.'" class="mt-3"> <a href="' . asset( $model->$name) . '" target="_blank" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> ' . basename($model->$name) . '</a><badge class="btn btn-danger" onclick="document.getElementById(\''.$randID.'\').remove();"><i class="fa fa-times"></i></badge>
<input type="text" name="'.$name.'[]" value="'.$model->$name.'" hidden>
</div>';
            }
        }

        $input .= '
                </div>';
        return $input;
    }

    public static function generateTextarea($key, $value, $model)
    {
        $key = $value['name'];
        if (!array_key_exists('required', $value)) {
            $value['required'] = '';
        }else{
            $value['required'] = 'required';
        }
        if (!array_key_exists('placeholder', $value)) {
            $value['placeholder'] = translate('backend','Enter '.$value['name']);
        }
        $value['label'] = translate('backend',$value['label']);

        $input = '<div class="form-group">
                    <label for="' . $key . '">' . $value['label'] . '</label>
                    <textarea ' . $value['required'] . ' class="form-control" id="' . $key . '" name="' . $key . '" placeholder="' . $value['placeholder'] . '" >' . old($key, isset($model) ? $model->$key : null) . '</textarea>
                </div>';
        return $input;
    }


}
