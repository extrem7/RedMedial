@extends('admin::layouts.base')

@section('content')
    @include('app_settings::_settings')
@endsection

@push('scripts')
    <script>
        $(function () {
            function updateInputName($input, index) {
                $($input).attr('name', $($input).attr('name').replace(/[0-9]/g, index));
            }

            $('input,textarea').addClass('bg-dark')

            $('body')
                .on('click', '.repeater-add', function (e) {
                    e.preventDefault();
                    const $repeater = $(e.currentTarget).closest('.repeater-wrapper')
                    const clone = $repeater.find('.repeater .row:last-child').clone(),
                        index = $repeater.find('.repeater .row').length;
                    clone.find('input,textarea').each(function () {
                        $(this).val('');
                        updateInputName(this, index);
                    });
                    clone.appendTo($repeater.find('.repeater'));
                })
                .on('click', '.repeater-remove', function (e) {
                    const $repeater = $(e.currentTarget).closest('.repeater-wrapper')
                    $(this).closest('.repeater .row').remove();
                    $repeater.find('.row').each(function (index) {
                        $(this).find('input,textarea').each(function () {
                            updateInputName(this, index);
                        });
                    });
                });
        });
    </script>
@endpush
