<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    @php
        $classPreview = '';
        if(isset($options['value'])) {
            $url = asset('myuploads/medias/'.$options['value']);
            $dataPreview = "data-preview='$url'";
            $classPreview = "has-preview";
        }
        else {
            $dataPreview = 'data-preview=""';
        }
    @endphp

    <div <?php echo $dataPreview; ?> class="preview_container {{ $classPreview }}" id="{{ $options['sibling'] }}">
        <label for="{{ $name }}" class="preview clearfix">
            <div class="close">x</div>
        </label>
        <?= Form::input('file', $name, $options['value'], $options['attr']) ?>
        <?php include base_path() . '/vendor/ycs77/laravel-form-builder-bs4/resources/views/errors.php' ?>
        <?php include base_path() . '/vendor/ycs77/laravel-form-builder-bs4/resources/views/help_block.php' ?>
    </div>



<?php endif; ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

@push('css')
    <style>
        #{{ $options['sibling'] }} {
            position:relative;
        }
        #{{ $options['sibling'] }} [type="file"] {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }
        #{{ $options['sibling'] }} .preview:after {
            top:50%;
            left:50%;
            transform:translateX(-50%) translateY(-50%);
            content: '{{ __("fields.noimage") }}';
            width: auto;
            display: inline;
            position: absolute;
            text-align: center;
        }

        #{{ $options['sibling'] }}.has-preview .preview:after {
            display:none;
        }

        #{{ $options['sibling'] }} .preview {
            height: 200px;
            width:100%;
            display: block;
            margin-bottom: 0;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;
            border-radius: 10px;
            border: 1px solid #8898aa;
            cursor: pointer;
        }
        #{{ $options['sibling'] }} .preview .close {
            position: absolute;
            right: 15px;
            top:15px;
            width: 25px;
            height:25px;
            border-radius:50%;
            font-size: 16px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: red;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        window.admin.editUploadFields.push({
            selector : '#{{ $options['sibling'] }}',
            multilang: {!! $useMultilang !!},
            currentLang: '{!! $currentLang !!}'
        })
    </script>
@endpush

