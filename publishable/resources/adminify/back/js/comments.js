jQuery(document).ready(function() {
   
    console.log('hello from comments !')
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    let isRedraw = false;

    function doQuery(type = '', query = {}, cb = function() {}) {

        let route = Route('finder', {
            type: type,
        });

        $.ajax({
            url: route,
            method: 'POST',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            data : query,
            type: 'json'
        })
        .done((result) => {

            if(cb && typeof cb == 'function') {
                cb(null, result);
            }
        })
        .fail((error) => {
            if(cb && typeof cb == 'function') {
                cb(error, null);
            }
        })
    }

    function formatOptions(labelToShow = '', results = []) {
        let a = [];

        $.each(results, function(key, result) {
            a.push(`<option value="${result.id}">${result[labelToShow]}</option>`);
        });

        return a;
    }

    $(document).on('change', 'select[name="model_id"]', function(e, details) {
        if(isRedraw) {
            return false;
        }
        isRedraw = true;
        let val = $(this).val();
        let parent_id_select = $(document).find('select[name="parent_id"]');
        if(parent_id_select.length > 0) {

            parent_id_select.children().removeAttr('disabled');
            let cibled_opt = parent_id_select.find('option[value="'+ val +'"]');
            cibled_opt.attr("disabled", true);
            

            parent_id_select.trigger("change");
            isRedraw = false;
        }
    });

    $(document).on('change', 'select[name="model_class"]', function(e) {

        let val = $(this).val();
        // console.log('val', val)
        let model_id_select = $(document).find('select[name="model_id"]');

        isRedraw = true;

        doQuery(val, 
        {   status_id : 1 }, 
            function(err, data) {
                if(err) {
                    console.log('whoops in comments', err);
                    return false;
                }

                let opts = formatOptions(data.labelToShow, data.models);
                console.log(opts);

                model_id_select.children().not( model_id_select.children().first() ).remove();
                if(data.models.length > 0) {
                    model_id_select.append( opts.join('') )

                    opts.unshift('<option value="0">'+ __('adminify.not_parent') +'</option>');
                    model_id_select.trigger('change');
                }

                isRedraw = false;

            })

        
    })

})
