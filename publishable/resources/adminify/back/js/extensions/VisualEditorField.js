export default function VisualEditorInit(fields) {
    $.each(fields, function(i, el) {
        Editor.defineElement();
    })
}
