<x-adminify-modal id="{{ $id ?? 'modalClassic' }}" modalClasses="{{ $classes ?? '' }}" modalBodyClass="{{ $modalBodyClass ?? '' }}"  modalDialogClasses="{{ $modalDialogClass ?? '' }}" title="{{ $modalTitle ?? '' }}" btnSave="{{ $btnSave ?? '' }}" btnClear="{{ $btnClear ?? '' }}">
    {!! $content ?? '' !!}
</x-adminify-modal>
