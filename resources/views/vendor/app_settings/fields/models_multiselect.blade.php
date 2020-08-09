@component('app_settings::input_group', compact('field'))
    <models-multiselect input-name="{{$field['name']}}"></models-multiselect>
@endcomponent
