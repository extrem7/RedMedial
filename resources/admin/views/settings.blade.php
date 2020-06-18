@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">

                @includeIf(config('app_settings.flash_partial'))

                <form method="post" action="{{ config('app_settings.url') }}" class="form-horizontal mb-3"
                      enctype="multipart/form-data" role="form">
                    {!! csrf_field() !!}

                    @if( isset($settingsUI) && count($settingsUI) )
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs bg-dark" id="custom-tabs-one-tab" role="tablist">
                                @foreach(Arr::get($settingsUI, 'sections', []) as $section => $fields)
                                    @php $name = Str::slug($fields['title'])  @endphp
                                    <li class="nav-item">
                                        <a class="nav-link text-light {{$loop->index==0?'active':''}}"
                                           id="{{$name}}-link" data-toggle="pill"
                                           href="#section-{{ $name }}" role="tab"
                                           aria-controls="section-{{ $name }}"
                                           aria-selected="true">
                                            <i class="{{ Arr::get($fields, 'icon', 'glyphicon glyphicon-flash') }}"></i>
                                            {{ $fields['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card card-tabs bg-dark">
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    @foreach(Arr::get($settingsUI, 'sections', []) as $section => $fields)
                                        @php $name = Str::slug($fields['title'])  @endphp
                                        <div class="tab-pane fade {{$loop->index==0?'show active':''}}"
                                             id="section-{{ $name }}" role="tabpanel"
                                             aria-labelledby="{{ $name }}">
                                            <div
                                                class="{{ Arr::get($fields, 'section_body_class', config('app_settings.section_body_class', 'card-body')) }}">
                                                @foreach(Arr::get($fields, 'inputs', []) as $field)
                                                    @if(!view()->exists('app_settings::fields.' . $field['type']))
                                                        <div
                                                            style="background-color: #f7ecb5; box-shadow: inset 2px 2px 7px #e0c492; border-radius: 0.3rem; padding: 1rem; margin-bottom: 1rem">
                                                            Defined setting <strong>{{ $field['name'] }}</strong> with
                                                            type <code>{{ $field['type'] }}</code> field is not
                                                            supported. <br>
                                                            You can create a <code>fields/{{ $field['type'] }}
                                                                .balde.php</code> to
                                                            render this input however you want.
                                                        </div>
                                                    @endif
                                                    @includeIf('app_settings::fields.' . $field['type'] )
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row m-b-md">
                        <div class="col-md-12">
                            <button class="btn-outline-primary btn">
                                {{ Arr::get($settingsUI, 'submit_btn_text', 'Save Settings') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
