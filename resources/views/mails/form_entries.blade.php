@extends('beautymail::templates.sunny')

@section('content')

    @include('beautymail::templates.sunny.contentStart')

    <table>
        <tbody>
            @foreach ($entries as $entry)
                @php
                    $field = $form->getField($entry['field_name']);
                    $type = $field->getType();   
                    $linkable_types = ['tel', 'email'];
                @endphp
                @if ($entry['field_name'] != 'form_class')
                    <tr>
                        <td width="35%" style="font-weight: bold;font-size:16px;">
                            {{ $entry['field_name'] }}
                        </td>
                        <td width="65%" style="font-weight: normal;font-size:16px;">
                            @if (in_array($type, $linkable_types))
                                <a href="{{ $type == 'tel' ? 'tel:+33'.$entry['content'] : 'mailto:'.$entry['content'] }}">
                                    {{ $entry['content'] }}  
                                </a>
                            @else  
                                {{ $entry['content'] }}  
                            @endif
                            
                        </td>
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