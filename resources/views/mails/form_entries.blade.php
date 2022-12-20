@extends('beautymail::templates.sunny')

@section('content')

    @include('beautymail::templates.sunny.contentStart')

    <table>
        <tbody>
            @foreach ($entries as $entry)
                @php
                    $field = $form->getField($entry['field_name']);
                    $options = $field->getOptions();
                    $type = $field->getType();   
                    $linkable_types = ['tel', 'email'];
                    $unshowable_fields = ['form_class', 'rgpd'];
                @endphp
                @if (!in_array($entry['field_name'], $unshowable_fields))
                    <tr>
                        <td width="100%" style="font-weight: bold;font-size:16px;">
                            {{ !empty($options['label']) ? $options['label'] : $entry['field_name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-weight: normal;font-size:16px;">
                            @if (in_array($type, $linkable_types))
                                <a href="{{ $type == 'tel' ? 'tel:'.$entry['content'] : 'mailto:'.$entry['content'] }}">
                                    {{ $entry['content'] }}  
                                </a>
                            @else  
                                @if(is_array($entry['content']))
                                    {{ implode(', ', $entry['content']) }}  
                                @else
                                    {{ $entry['content'] }}  
                                @endif
                            @endif
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 5px;">&nbsp;</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @include('beautymail::templates.sunny.contentEnd')

    {{-- @include('beautymail::templates.sunny.button', [
        	'title' => 'Click me',
        	'link' => 'http://google.com'
    ]) --}}

@stop