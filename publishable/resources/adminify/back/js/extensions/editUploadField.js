export default function EditUploadInititalization(fields) {

    $.each(fields, function(i, el) {


        var preview_container_jq = $(el.selector);
        var data_preview = preview_container_jq.attr('data-preview')

        var preview = preview_container_jq.find('.preview');
        var preview_input = preview_container_jq.find('[type="file"]');
        var preview_clear = preview_container_jq.find('.close');

        if(data_preview.length > 0) {
            setPreview(data_preview);
        }

        preview_input.on('change', function(e) {
            readTheFile(e);
        })

        preview_clear.on('click', function(e) {
            e.preventDefault();
            setPreview('')

        })

        function setPreview(previewUrl) {
            if(previewUrl == '') {
                preview.parent().removeClass('has-preview')
            }
            else {
                preview.parent().addClass('has-preview')
            }
            preview.css(
                'background-image' , "url(" + previewUrl + ")"
            )
        }

        function readTheFile(evt) {
            var files = evt.target.files; // FileList object

            // use the 1st file from the list
            f = files[0];

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = function(e) {
                setPreview(e.target.result);
            }


            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    })


}
