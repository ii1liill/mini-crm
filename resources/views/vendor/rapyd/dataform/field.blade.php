@if (in_array($field->type, array('hidden','auto')) OR !$field->has_wrapper )

    {!! $field->output !!}

    @if ($field->message!='')
    <span class="help-block">
        <span class="glyphicon glyphicon-warning-sign"></span>
        {!! $field->message !!}
    </span>
    @endif

@else
    <div class="row cl clearfix{!!$field->has_error!!} fg_{!!$field->type!!}" id="fg_{!! $field->name !!}" >

        @if ($field->has_label)
            <label for="{!! $field->name !!}" class="form-label col-xs-4 col-sm-2">
                @if ($field->req) 
                <span class="c-red">*</span>
                @endif
                {!! $field->label.$field->star !!}</label>
            <div class="formControls col-xs-8 col-sm-9" id="div_{!! $field->name !!}">
        @else
            <div class="formControls col-xs-12 col-sm-12" id="div_{!! $field->name !!}">
        @endif
            {!! $field->output !!}
            @if(count($field->messages))
                @foreach ($field->messages as $message)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $message !!}
                    </span>
                @endforeach
            @endif

        </div>

            
            
    </div>
@endif
