export default function GeneratorPasswordInititalization(fields) {
    $.each(fields, function(i, el) {
        var elScope = $('#'+el.selector);
        var Input = elScope.find('input[type="text"]');
        var BtnGenerator = elScope.find('button');

        BtnGenerator.on('click', function(e) {
            e.preventDefault();
            Input.val( PasswordGenerator() );
        })
    })

    function PasswordGenerator() {
        return Math.random().toString(36).slice(2);
    }

}
