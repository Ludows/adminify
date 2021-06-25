jQuery(document).ready(function($) {

    let modale = $('#globalSearch');
    let appendSearchable = $('#appendSearchable');

    if(modale.length > 0) {

        let input = modale.find('#js-search-entity');

        let handler = $('.js-search-btn');
        console.log(handler, input)

        handler.on('click', function(e) {
            e.preventDefault();
            modale.modal('show');
        })

        input.on('keyup', function(e) {
            console.log('change')
            if(input.val().length > 2) {
                console.log(Route('searchable'), input.val())
                $.ajax({
                    'method' : 'POST',
                    'url' : Route('searchable'),
                    'dataType' : 'json',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'data' : {
                        'query' : input.val()
                    }
                })
                .done((data) => {
                    appendSearchable.html('');
                    if(Object.keys(data.response).length > 0) {
                        let $html = generateHtml(data.response, data.labels);
                        appendSearchable.append($html);
                    }
                })
                .fail((err) => {
                    console.log(err)
                })
            }
            if(input.val().length < 3) {
                appendSearchable.html('');
            }
        })

        modale.on('hide.bs.modal', function() {
            input.val('');
        })

        function generateHtml(data, labels) {
            let k = Object.keys(data);
            let st = `<div class="list-group list-group-flush">`;
            if(k.length > 0) {
                console.log(data);

                $.each(k, function(i, localKey) {
                    st += `${data[localKey].length} entité trouvée${data[localKey].length > 1 ? 's' : ''} pour ${localKey}<br>`;
                    $.each(data[localKey], function(i, item) {
                        st += `<a href="${item.url}" class="list-group-item list-group-item-action">
                                ${item[labels[localKey]]}
                              </a>`;
                    })
                })
            }



            st += `</div>`;

            return st;
        }



    }

})
